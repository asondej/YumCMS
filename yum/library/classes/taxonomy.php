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
   
    //TODO: create methods that scans folder (for meals) and recipe files (for other taxonomies) and make changes in respective taxonomy files

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