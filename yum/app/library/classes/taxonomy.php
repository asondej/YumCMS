<?php 
declare(strict_types=1);

namespace Library\Classes;
// i put it in classes, he wants to use just a function

class Taxonomy {

    private static $folder = '/content/taxonomy/';
    private static $meals  = "meal";
    private static $types  = "type";
    private static $tags  = "tag";
    private static $diets  = "diet";
    private $meals_cache_date;
   

    public function get_meals_and_recipes($includeEmpty = true) : array 
    {
        $allRecipes = Recipe::list_all_recipes(true);
        $recipesAssoc = [];

        dump($allRecipes);

        array_walk($allRecipes, function(&$value, $key) use (&$recipesAssoc, $includeEmpty) {
            
            $key_value_transform = explode('/', $value);
            $recipesAssoc[$key_value_transform[0]]['empty'] = '';
            array_push($recipesAssoc[$key_value_transform[0]], $key_value_transform[1]);
            $recipesAssoc[$key_value_transform[0]] = array_filter($recipesAssoc[$key_value_transform[0]]); 
        });

        if($includeEmpty) {

            $recipes_folder = $_SERVER["DOCUMENT_ROOT"].'/recipes/';
            $meals_subfolders = glob($recipes_folder."*/", GLOB_BRACE); 
            $meals_subfolders = array_map(
                function ($value) {
                    $parts = explode('/', $value);
                    array_pop($parts);
                    $value = end($parts);
                    $name_parts = explode('_', $value);
                    $value = end($name_parts);
                    return $value;
                }, $meals_subfolders
            );

            $folder_name_as_keys = array_flip($meals_subfolders);
            foreach ($folder_name_as_keys as $folder=>&$array) {
                $array = [];
            }
            $difference =  array_diff_key($folder_name_as_keys, $recipesAssoc);
            if( !empty($difference) ) {
                $recipesAssoc =  array_merge($difference, $recipesAssoc);
            }            
        }

        return $recipesAssoc;
    }

    public function update_meals_json( $cache = true ) : void 
    {

        # edit json content
        $meals_from_folders = $this->get_meals_and_recipes();
        $meals_json = file_get_contents(ABS_PATH. $this::$folder . $this::$meals); //dump($meals_json);
        $meals_json = json_decode($meals_json); 

        

        foreach ($meals_json as $meal_slug=>$meal_details) { // json file with meals details

            $json_meal = strtolower( $meal_slug );
            
            foreach ($meals_from_folders as $meal_name=>$recipes_array) { // folders with recipes

                $meal_name = strtolower($meal_name);

                if( str_contains($json_meal, $meal_name)  ) {

                    $meal_details->posts = $recipes_array;
                    
                } 
            }
        }

        foreach ($meals_json as $meal_in_json=>$json_meal_details ) {
            if( !array_key_exists($meal_in_json, $meals_from_folders) ) { // if mealname from json doesn't exist as a folder name
                unset($meals_json->{$meal_in_json});
            } 
        }

        $json_as_array = get_object_vars($meals_json);

        foreach ($meals_from_folders  as $folder=>$folder_contents) {
            
            if( !array_key_exists($folder, $json_as_array) ) { // if folder name doesn't exist in json file
                $meals_json->{$folder} = (object) [
                    'name' => $folder,
                    'description' => '',
                    'posts' => []
                ];
                if( !empty($folder_contents) ) {
                    $meals_json->{$folder}->posts =  $folder_contents;
                    dump($folder_contents);
                } 
            } 
        }

        # save edited json as file

        $updated_json_data = json_encode($meals_json, JSON_PRETTY_PRINT);
        $handler = fopen( ABS_PATH. $this::$folder . $this::$meals, 'w+' );
        fwrite( $handler, $updated_json_data);

        //TODO: add cache to the code above


        // dump($meals_json, 'obiekt' );
        // dump($meals_from_folders);

    }

    public static function get_meals() : array
    {
        $path = ABS_PATH . self::$folder . self::$meals;
        $file = file_exists($path) ? file_get_contents($path) : self::$meals. "taxonomy file not found"; 
        if (json_decode($file)) {
            return json_decode($file, true);
        } else {
            return [];
        }
    }

    public static function get_diets() : array
    {
        $path = ABS_PATH . self::$folder . self::$diets;
        $file = file_exists($path) ? file_get_contents($path) : self::$diets . " taxonomy file not found"; 
        if (json_decode($file)) {
            return json_decode($file, true);
        } else {
            return [];
        }
        
    }

    public static function get_types() : array
    {
        $path = ABS_PATH . self::$folder . self::$types;
        $file = file_exists($path) ? file_get_contents($path) : self::$types . " taxonomy file not found"; 
        if (json_decode($file)) {
            return json_decode($file, true);
        } else {
            return [];
        }
    }

    public static function get_tags() : array
    {
        $path = ABS_PATH . self::$folder . self::$tags;
        $file = file_exists($path ) ? file_get_contents($path ) : self::$tags . " taxonomy file not found"; 
        if (json_decode($file)) {
            return json_decode($file, true);
        } else {
            return [];
        }
    }


}