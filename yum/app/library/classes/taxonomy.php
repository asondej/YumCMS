<?php 
declare(strict_types=1);

namespace Library\Classes;

class Taxonomy {

    private static $folder  = '/content/taxonomy/';
    private static $meals   = "meal";
    private static $types   = "type";
    private static $tags    = "tag";
    private static $diets   = "diet";
    protected $slug;
    public $lastUpdate_meals;
    public $lastUpdate_diet;
    public $lastUpdate_types;
    public $lastUpdate_tags;
    public static $diet_pattern = '/(\b\w*\s*\w+\b)\s*(\[.*x.*\])/';
    public static $taglike_pattern = '/([^,\n]+)/';



    public function __construct( ?string $slug =  null)
    {
        $this->lastUpdate_meals = filemtime(ABS_PATH. $this::$folder . $this::$meals);
        $this->lastUpdate_diet  = filemtime(ABS_PATH. $this::$folder . $this::$diets);
        $this->lastUpdate_tags  = filemtime(ABS_PATH. $this::$folder . $this::$tags);
        $this->lastUpdate_types = filemtime(ABS_PATH. $this::$folder . $this::$types);
        $this->slug = $slug;

    }


    public function get_meals_and_recipes(bool $includeEmpty = true) : array 
    {
        $allRecipes = Recipe::list_all_recipes(true);
        $recipesAssoc = [];

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

    public function update_meals_json( bool $cache = true, int $cachtime = 30 * 60) : void 
    {

        # edit json content
        $meals_from_folders = $this->get_meals_and_recipes();
        $meals_json = file_get_contents(ABS_PATH. $this::$folder . $this::$meals); //debug($meals_json);
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

        $json_as_array = get_object_vars($meals_json); // get objects properties

        foreach ($meals_from_folders  as $folder=>$folder_contents) {
            
            if( !array_key_exists($folder, $json_as_array) ) { // if folder name doesn't exist in json file
                $meals_json->{$folder} = (object) [
                    'name' => $folder,
                    'description' => '',
                    'posts' => []
                ];
                if( !empty($folder_contents) ) {
                    $meals_json->{$folder}->posts =  $folder_contents;
                } 
            } 
        }

        # save edited json as file

        $updated_json_data = json_encode($meals_json, JSON_PRETTY_PRINT);
        $now = time();

        if ($cache) {
            if( ($now - $this->lastUpdate_meals) > $cachtime ) {
                $handler = fopen( ABS_PATH. $this::$folder . $this::$meals, 'w+' );
                fwrite( $handler, $updated_json_data);
                fclose($handler);
            }
        } else {
            $handler = fopen( ABS_PATH. $this::$folder . $this::$meals, 'w+' );
            fwrite( $handler, $updated_json_data);
            fclose($handler);
        }
    }

/*
* string $taxonomy ['tags', 'types', 'diets']
*/
    public function update_taxonomy_json ( string $taxonomy, bool $cache = true, int $cachtime = 120 * 60) : void 
    {   

       
        # edit json content
        $taxonomy_file_path = match ($taxonomy) {
            'tags' => ABS_PATH. $this::$folder . $this::$tags,
            'types' => ABS_PATH. $this::$folder . $this::$types,
            'diets' => ABS_PATH. $this::$folder . $this::$diets,
        };

        $taxonomy_json = file_get_contents($taxonomy_file_path);
        $taxonomy_json = json_decode($taxonomy_json); 
        $taxonomy_from_recipes = self::taxonomy_with_recipes_array($taxonomy, true, true);
        $taxonomy_from_recipes_rawnames = self::taxonomy_with_recipes_array($taxonomy, true);


        foreach ($taxonomy_json as $taxonomy_slug=>$taxonomy_details) { // json file with taxonomy details

            $json_taxonomy_name = strtolower($taxonomy_slug);

            foreach($taxonomy_from_recipes as $taxname=>$recipes) { // taxonomies from actual recipes

                if( $json_taxonomy_name == $taxname ) { // update json taxonomies with values from recipes
                    $taxonomy_details->posts = $recipes;
                } 
            }

                      
        }
            
            
            ## if json contains more values than array from recipes - clear array with posts for the tax value
            $json_as_array = get_object_vars($taxonomy_json); // get objects properties 
            $excess = array_diff_key($json_as_array, $taxonomy_from_recipes);

            if( !empty($excess) ) {
                foreach ($excess as $empty_tax_value=>$contents) {

                    if(!empty($contents->description)) {
                        $taxonomy_json->{$empty_tax_value}->posts = []; // preserve value if there is any description
                    } else {
                        unset($taxonomy_json->{$empty_tax_value}); // otherwise delete it 
                    }
                    
                }
            }
           
            ##  if array from recipes contain more values than json - add new tax value obj to json

            $shortage = array_diff_key($taxonomy_from_recipes, $json_as_array );

            if ( !empty($shortage) ) {
            
                $slugs = array_keys($taxonomy_from_recipes); sort($slugs);
                $names = array_keys($taxonomy_from_recipes_rawnames); sort($names);
                $taxonomy_slug_name_array = array_combine($slugs, $names);

                foreach ($shortage as $new_tax_value=>$new_details) {

                    $taxonomy_json->{$new_tax_value} = (object) [
                        'name' => ucfirst( $taxonomy_slug_name_array[$new_tax_value]),
                        'description' => '',
                        'posts' => []
                    ];
                    $taxonomy_json->{$new_tax_value}->posts = $new_details;

                }

            }

        # save edited json as file

        $updated_json_data = json_encode($taxonomy_json, JSON_PRETTY_PRINT);
        $now = time();

        $last_update = match ($taxonomy) {
            'tags' => $this->lastUpdate_tags,
            'types' => $this->lastUpdate_types,
            'diets' => $this->lastUpdate_diet,
        };

        if ($cache) {
            if( ($now - $last_update) > $cachtime ) {
                $handler = fopen( $taxonomy_file_path, 'w+' );
                fwrite( $handler, $updated_json_data);
                fclose($handler);
            }
        } else {
            $handler = fopen( $taxonomy_file_path, 'w+' );
            fwrite( $handler, $updated_json_data);
            fclose($handler);
        }

    }

    public static function recipes_with_taxonomies_array() : array
    {

        $allRecipes = Recipe::list_all_recipes(full_path:true);
        $all = [];
        foreach($allRecipes as $recipe) {

            $elements = explode("/", $recipe);
            array_pop($elements);
            $elements = explode("_", end($elements));
            $meal = str_replace('-', ' ', end($elements));
            $raw_content = file_get_contents($recipe);
            $content_parts = Recipe::split_raw($raw_content); 
            $meta = json_decode($content_parts[0], true);
            array_push($all,[
                "recipe" => $recipe,
                "title" => $meta['title'],
                "image" => $meta['image'],
                "diet" => $content_parts[2],
                "meal" => $meal,
                "tags" => $content_parts[3],
                "types" => $content_parts[4],
            ]);

        }

        
        //dump(file_get_contents());
    
        foreach ($all as &$recipe_tax_details) {

            $diet = $recipe_tax_details['diet'];
            $tags = $recipe_tax_details['tags'];
            $types = $recipe_tax_details['types'];
            $matches = '';
            if(stripos($diet, "diet") ) { // get diet from raw
                preg_match(self::$diet_pattern, $diet, $matches);
                $diet = $matches[1] ?? '';
                $diet = str_ireplace('diet', '', $diet);
                $recipe_tax_details['diet'] = trim($diet);
            }
            if(stripos($tags, "tags") ) { // get tags from raw
                $tags_array = self::taglike_from_raw($tags);
                $recipe_tax_details['tags'] = $tags_array;
            }
            if(stripos($types, "type") ) { // get types from raw

                $types_array = self::taglike_from_raw($types);
                $recipe_tax_details['types'] = $types_array;
            }

        }
        
        return $all;
    }

/*
* string $taxonomy ['tags', 'types', 'diets']
*/
    public static function taxonomy_with_recipes_array(string $taxonomy, bool $slug_only = false, bool $sanitize_slug = false ) : array
    {
        $all = self::recipes_with_taxonomies_array();
    
        $all_tax_values = [];
        if($taxonomy === 'diets') { // for diet
                foreach ($all as $recipe_details) {
                    $recipe = $recipe_details['recipe'];
                    $diet_value = $recipe_details['diet'];

                    if (empty($diet_value)) {
                        continue;
                    } elseif (array_key_exists($diet_value, $all_tax_values ) ) {
                        array_push($all_tax_values[$diet_value], $recipe );
                    } else {
                        $all_tax_values[$diet_value] = [$recipe];
                    }
                }
        } else { // for taglike
            foreach ($all as $recipe_details) {

                $recipe = $recipe_details['recipe'];
                $tax_values = $recipe_details[$taxonomy];

                foreach ($tax_values as $tax_value) {
                    
                    if(array_key_exists($tax_value, $all_tax_values ) ) {
                        //$value = ucfirst($tax_value);
                        array_push($all_tax_values[$tax_value], $recipe );
                    } else {
                        $all_tax_values[$tax_value] = [$recipe];
                    }
                }

            }
        }


            if($slug_only) {
                foreach ($all_tax_values as $tax_name=>&$recipes) { // get rid of filepath
                    $recipes = array_map(function($value)  {
                        $value = explode('/', $value);
                        $value = end($value);
                        $value = str_replace('.md', '', $value);
                        return $value;
                    }, $recipes );
                }
            }

            if($sanitize_slug) {
                foreach ($all_tax_values as $raw_tax_name=>$recipes_array) { 
                    if(self::taxonomy_to_slug($raw_tax_name) !== $raw_tax_name) {
                        $all_tax_values[self::taxonomy_to_slug($raw_tax_name)] = $all_tax_values[$raw_tax_name];
                        unset($all_tax_values[$raw_tax_name]);
                    }
                }
            }
        
            

        return  $all_tax_values;
    }

    protected static function taglike_from_raw(string $raw) : array 
    {
        $tags_array = preg_grep(self::$taglike_pattern, explode("\n", $raw));

        $tags_array = array_map(function($value){
            $value = trim($value); // in case that there are some extra new lines after tax values
            return $value;
        }, $tags_array);

        $tags_array = array_filter($tags_array);

        if( count($tags_array) > 1 ) { 
            $tags_array = end($tags_array); 
        } else { $tags_array = ''; } // if there are no taglike values

       
        $tags_array = explode(',', $tags_array);
        $tags_array = array_map(function($value){
            $value = trim($value); 
            return $value;
        }, $tags_array);

        return array_filter($tags_array);
    }

    public static function get_meals() : array
    {
        $path = ABS_PATH . self::$folder . self::$meals;
        $file = file_exists($path) ? file_get_contents($path) : self::$meals. " taxonomy file not found"; 
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

    public static function taxonomy_to_slug(string $taxonomy_name) : string 
    {
        $search = [' ', '/', '\\', 'ć', 'ś', 'ą', 'ż', 'ó', 'ł', 'ś', 'ź', 'ń', 'ę'];
        $replace = ['-', '-', '-', 'c', 's', 'a', 'z', 'o',  'l', 's', 'z', 'n', 'e'];
        $taxonomy_name = strtolower($taxonomy_name); 
        $taxonomy_name = strip_tags($taxonomy_name);
        $taxonomy_name = str_replace($search, $replace, $taxonomy_name);  
        return $taxonomy_name; 
    }

/*
* string $taxonomy ['tag/s', 'type/s', 'diet/s', 'meal/s']
*/
    public static function tax_url_from_slug(string $slug, string $taxonomy) : string
    {
        $tax = match ($taxonomy) {
            'tags', 'tag' => 'tag',
            'types', 'type' => 'type',
            'diets', 'diet' => 'diet',
            'meals', 'meal' => 'meal',
        };

        $url = 'http://'.$_SERVER['SERVER_NAME'].'/'.$tax.'/'.$slug.'/';
        return $url;
    }

/*
* string $taxonomy ['tags', 'types', 'diets', 'meals']
*/
    public static function tax_list_url(string $taxonomy) : string
    {
        return 'http://'.$_SERVER['SERVER_NAME'].'/'.$taxonomy;
    }

/*
* string $taxonomy ['tags', 'types', 'diets', 'meals']
*/
    public static function taxonomy_generate_links(string $taxonomy, ?string $class = null, array $conf = ['uppercase' => false], array $html_open_close = ['<a href="%s" class="%s" >','</a>'],  ) : string 
    {

        if(empty($class)) {
            $class = 'tax_'.$taxonomy.'_allLinks';
        }
        $taxonomy_file_path = match ($taxonomy) {
            'tags' => ABS_PATH. self::$folder . self::$tags,
            'types' => ABS_PATH. self::$folder . self::$types,
            'diets' => ABS_PATH. self::$folder . self::$diets,
            'meals' => ABS_PATH. self::$folder . self::$meals,
        };


        $taxonomy_json = file_get_contents($taxonomy_file_path);
        $taxonomy_json = json_decode($taxonomy_json); 

        $html ='';
        foreach ($taxonomy_json as $tax_name=>$tax_details)  {
            if($conf['uppercase']) {
                $name = ucfirst($tax_details->name);
            } else {
                $name = $tax_details->name;
            }
            $url = self::tax_url_from_slug($tax_name, $taxonomy);
            $html.= sprintf($html_open_close[0], $url, $class ).$name.$html_open_close[1];
        }

        return $html;
    }


    public function taxonomyPage_single() : array // page details
    {

        $parts = [];
        preg_match('/-(.+)+$/', $this->slug, $parts);
        $tax_type = [];
        preg_match('/^(\w+)-/', $this->slug, $tax_type);
        $taxonomy_name = end($tax_type);
        $taxonomy_value = end($parts);
        $taxonomy_value = str_replace('-', ' ', $taxonomy_value);

        $posts_in = self::list_recipes_in_taxonomy($this->slug);
        

        $page = [
            'tax_name' => $taxonomy_name,
            'tax_value' => $taxonomy_value,
            'meta' => [
                'title' => ucfirst($taxonomy_name). ': ' .$taxonomy_value
            ], 
            'posts'=> $posts_in,
        ];

        //dump($page);
        
        return $page;
    }

    public function taxonomyPage_list($slug) : array // page details
    {
        $page = [

            'meta' => [
                'title' =>ucfirst($slug),
            ],
            'values' => self::list_taxonomy($slug),
        ];

        return $page;
    }


    public static function list_taxonomy(?string $slug = null) : ?array 
    {

        if ($slug === null) {
            $query = filter_input(INPUT_GET, "request");
        } else {
            $query = $slug;
        }
        
        $taxonomies = ['tags', 'meals', 'types', 'diets'];

        $values = [];

        if ( in_array($query, $taxonomies) ) {

            $values_from_json = match ($query) {
                'tags' => self::get_tags(),
                'types' => self::get_types(),
                'diets' => self::get_diets(),
                'meals' => self::get_meals(),
            };

            foreach($values_from_json as $slug=>$details) {
                $url = self::tax_url_from_slug($slug, $query);
                $values[ucwords($details['name'])] = $url;
            }

            return $values;

        } else {
            return null;
        }
    
    }


    public static function list_recipes_in_taxonomy(?string $slug = null) : ?array 
    {
        
        if ($slug === null) {
            $slug = filter_input(INPUT_GET, "request");
            if($slug===null) {
                $slug = 'home';
            }
            $slug = preg_replace('/\//', '-', $slug, 1);
            $slug = preg_replace('/\//', '', $slug, 1);
            
        } 
        
        $info = Content::tax_info_from_slug($slug);

        $taxonomies = ['tag', 'meal', 'type', 'diet'];

        $values = [];


        if ( in_array($info['tax_type'], $taxonomies) ) {

            $values_from_json = match ($info['tax_type']) {
                'tag' => self::get_tags(),
                'type' => self::get_types(),
                'diet' => self::get_diets(),
                'meal' => self::get_meals(),
            };
            
            $post_with_tax_value = $values_from_json[ $info['slug'] ]['posts'];
            $recipes = self::recipes_with_taxonomies_array();

            foreach ($post_with_tax_value as $post) {
                
                foreach ($recipes as $details) {
                    $path = $details['recipe'];

                    if ( str_contains($path, $post) ) {
                        $values[$post] = $details;
                    }
                    
                }
              
            }
            return $values;

        } else {
            return null;
        }
    }

}