<?php 
declare(strict_types=1);
namespace Library\Classes;

// include ABS_PATH . 'library/classes/interface/interfacePost.php';

use Library\Interface\InterfacePost;

class Recipe implements InterfacePost
{

    public function test (string $ok) : void 
    {}  

    // public static function get_recipe_path(string $slug) : string
    // {
    //     dump($slug,"get_recipe_path");
    //     $slug_recipe = explode("/", $slug);
    //     $slug_recipe = array_pop( $slug_recipe ); // only post name, without "recipe"
    //     return Content::get_content_path("post", $slug_recipe);
    // }

    public function getPost(string $slug): void
    {
        $slug_recipe = explode("/", $slug);
        $slug_recipe = array_pop( $slug_recipe ); // only post name, without "recipe"

        $path = Content::get_content_path("post", $slug_recipe);

        if (!file_exists($path)) {
            return;
        }

        $markdown = file_get_contents($path);
        dump($markdown);
    }
}
