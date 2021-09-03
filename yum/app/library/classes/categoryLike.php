<?php 
declare(strict_types=1);

namespace Library\Classes;
use Library\Interface\Interface_categorylike;


class CategoryLike implements Interface_categorylike {

    /*
    * string $taxonomy ['diet', 'meal']
    */
    public static function get_all(string $taxonomy, bool $popular_sort = false) : array
    {
        $taxonomy_with_number = [];

        $values = file_get_contents(ABS_PATH.'/content/taxonomy/'.$taxonomy);

        $values = json_decode($values, true);

        foreach ($values as $value=>$details) {

            $taxonomy_with_number[$value] = count($details['posts']);

        }

        if($popular_sort) {
            arsort($taxonomy_with_number);
        }

        return $taxonomy_with_number;
        
    }

}