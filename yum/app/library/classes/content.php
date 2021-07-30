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

       // dump($slug);
        // debug(strpos($slug , "recipe/"));
        // debug(Recipe::post_exist($slug));
 
        if ( Recipe::post_exist($slug) && strpos($slug , "recipe/") == 0 ) { // the second cond will always be true, as slug is being set to "recipe/xxx" 
            // TODO: fix this, one day, someday, maybe... ;-)
            return true;
        } else {
            return false;
        }
    }
    public static function is_taxonomy(string $slug): bool|int
    {
        $parts = explode("-", $slug);
        if( count($parts)===2 ) { // it is taxonomy
            return true;
        } else {
            return false;
        }
    }
    public static function is_meal(string $slug) : bool
    {

        if ( self::is_taxonomy($slug) ) { // check if it's taxonomy

            $parts = explode("-", $slug);
            $tax_type = $parts[0];
            $slug = array_pop($parts);
            

            $json_meals = array_keys(Taxonomy::get_meals()); // get list of eexisting meals in json


            if ( in_array($slug, $json_meals) && $tax_type == "meal") { // check if it's existing taxonomy from json with mels
                return true;
            } else { // it's not in json, so...
                return false;
            }

        } else { // it's not a taxonomy, so...
            return false;
        }

    }
    public static function is_tag(string $slug) : bool
    {

        if ( self::is_taxonomy($slug) ) { // check if it's taxonomy

            $parts = explode("-", $slug);
            $tax_type = $parts[0];
            $slug = array_pop($parts);
            

            $json_meals = array_keys(Taxonomy::get_tags()); // get list of eexisting meals in json

            if ( in_array($slug, $json_meals) && $tax_type == "tag") { // check if it's existing taxonomy from json with mels
                return true;
            } else { // it's not in json, so...
                return false;
            }

        } else { // it's not a taxonomy, so...
            return false;
        }

    }
    public static function is_diet(string $slug) : bool
    {

        if ( self::is_taxonomy($slug) ) { // check if it's taxonomy

            $parts = explode("-", $slug);
            $tax_type = $parts[0];
            $slug = array_pop($parts);
            

            $json_meals = array_keys(Taxonomy::get_diets()); // get list of eexisting meals in json

            if ( in_array($slug, $json_meals) && $tax_type == "diet") { // check if it's existing taxonomy from json with mels
                return true;
            } else { // it's not in json, so...
                return false;
            }

        } else { // it's not a taxonomy, so...
            return false;
        }

    }
    public static function is_type(string $slug) : bool
    {

        if ( self::is_taxonomy($slug) ) { // check if it's taxonomy

            $parts = explode("-", $slug);
            $tax_type = $parts[0];
            $slug = array_pop($parts);
            

            $json_meals = array_keys(Taxonomy::get_types()); // get list of eexisting meals in json

            if ( in_array($slug, $json_meals) && $tax_type == "type") { // check if it's existing taxonomy from json with mels
                return true;
            } else { // it's not in json, so...
                return false;
            }

        } else { // it's not a taxonomy, so...
            return false;
        }

    }


}