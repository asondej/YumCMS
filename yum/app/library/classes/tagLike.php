<?php 
declare(strict_types=1);

namespace Library\Classes;
use Library\Interface\Interface_taglike;

class tagLike implements Interface_taglike {

    /*
    * string $taxonomy ['tag', 'type']
    */
    public static function get_all(string $taxonomy) : array
    {
        $all = [];

        $values = file_get_contents(ABS_PATH.'/content/taxonomy/'.$taxonomy);
        $all = json_decode($values, true);

        return $all;
    }

    public static function get_all_with_url(string $taxonomy) : array 
    {
        $all_with_url = [];
        $all = self::get_all($taxonomy);

        foreach ($all as $name=>$details) {
            $slug = Taxonomy::taxonomy_to_slug($name);
            $all_with_url[$name] = 'http://'.$_SERVER['SERVER_NAME'].'/'.$taxonomy.'/'.$slug;
        }

        return $all_with_url;
    }

    public static function get_popular(string $taxonomy, int $howmany = 8) : array 
    {
        $tax = match($taxonomy) {
            'tag' => 'tags',
            'type' => 'types'
        };

        $values = self::get_all($taxonomy);

        usort($values, function($a,$b){
            return count($b['posts']) <=> count($a['posts']);
        });

        for ($i = 0; $i <= $howmany; $i++){

            $popular[$values[$i]['name']] = Taxonomy::tax_url_from_slug(Taxonomy::taxonomy_to_slug($values[$i]['name']), $tax );
        }

        return $popular;
    }


}