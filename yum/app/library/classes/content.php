<?php 
declare(strict_types=1);

namespace Library\Classes;

class Content {

    public static function get_content_path(string $content_type, string $slug) : string
    {
        return sprintf('%s/content/%s/%s', ABS_PATH, $content_type, $slug);
    }

    public static function is_page( string $slug ): bool
    {
       $path = self::get_content_path("page", $slug );
       if (file_exists($path)) {
           return true;
       } else {
           return false;
       }
    }

    public static function is_post(string $slug): bool
    {

        if ( Recipe::post_exist($slug) && strpos($slug , "recipe/") == 0 ) { // the second cond will always be true, as slug is being set to "recipe/xxx" 
            // TODO: fix this, one day, someday, maybe... ;-)
            return true;
        } else {
            return false;
        }
    }

    public static function is_taxonomy(string $slug): bool|int
    {
        $taxonomies = ['diet', 'diets', 'meal', 'meals', 'tag', 'tags', 'type', 'types'];
        
        $parts = explode("-", $slug);
        $contains = array_intersect($taxonomies, $parts);
        
        if( count($parts)>=2 && !empty($contains) ) { // it is taxonomy
            return true;
        } else {
            return false;
        }
    }

    public static function tax_info_from_slug($slug) : array {
        $parts = [];
        preg_match('/-(.+)+$/', $slug, $parts);
        $tax_type = [];
        preg_match('/^(\w+)-/', $slug, $tax_type);
        $tax_type = end($tax_type);
        $slug = end($parts);

        return [
            'tax_type'  => $tax_type,
            'slug'      => $slug,
        ];
    }
    /*
    * string $type ['tag', 'type', 'meal', 'diet']
    */  
    public static function is_tax_type( string $type, string $slug) : bool {

        if ( self::is_taxonomy($slug) ) { // check if it's taxonomy

            $info = self::tax_info_from_slug($slug);

            $json_tax = match ($type) {
                'tag' => array_keys(Taxonomy::get_tags()), 
                'type'=> array_keys(Taxonomy::get_types()), 
                'meal'=> array_keys(Taxonomy::get_meals()), 
                'diet'=> array_keys(Taxonomy::get_diets()), 
            };

            if ( in_array($info['slug'], $json_tax) && $info['tax_type'] == $type) { // check if it's existing taxonomy from json 
                return true;
            } else { // it's not in json, so...
                return false;
            }

        } else { // it's not a taxonomy, so...
            return false;
        }

    }

 
    /*
    * string $type ['taglike', 'categorylike']
    */   
    public static function is_list(string $slug, string $type) : bool 
    {

        switch ($type) {
            case 'taglike':
                if($slug === 'tags' || $slug === 'types') {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'categorylike':
                if($slug === 'diets' || $slug === 'meals') {
                    return true;
                } else {
                    return false;
                }
                break;
        }

    }

}