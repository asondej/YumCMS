<?php 
declare(strict_types=1);
namespace Library\Classes;

// include ABS_PATH . 'library/classes/interface/interfacePost.php';

use League\CommonMark\GithubFlavoredMarkdownConverter;
use League\CommonMark\CommonMarkConverter;

class Recipe
{
    private string $slug;

    public function __construct(string $slug) 
    {
        $this->slug = $slug;
        //$this->getPost($this->slug);

        //dump($this->slug);
    }

    public function getPost(): ?array
    {
    
        $path = $this->get_post_file_path($this->slug);

        if (!file_exists($path)) {
            return null;
        }

        $post_raw = file_get_contents($path);
        $post_raw = $this->split_raw($post_raw);

        $post_meta = $post_raw[0];
        $post_content_raw = $post_raw[1];

        $post = [
            "meta" => [
                "title" => json_decode($post_meta, true)["title"],
                "slug" => json_decode($post_meta, true)["slug"],
                "image" => json_decode($post_meta, true)["image"],
            ],
            "content" => $this->parse_markdown($post_content_raw),
        ];

        $post = array_merge($this->get_taxonomy($this->slug), $post);
      
     
        return $post;

    }

    private function split_raw(string $raw_content) : array
    {
        return preg_split('/\s+={3,}\s+/', $raw_content);
    }

    private function get_post_file_path() : string
     {
        $slug_recipe = explode("/", $this->slug);
        $slug_recipe = array_pop( $slug_recipe ); // only post name, without "recipe"

        $path = Content::get_content_path("post", $slug_recipe);
        return $path;
    }
    
    private function get_taxonomy() : ?array
    {

        $taxonomy = [ 'taxonomy' => [
            'meals' => [],
            'diets' => [],
            'types' => [],
            'tags' => [],
            ]
        ];

        $slug_recipe = explode("/", $this->slug);
        $slug_recipe = array_pop( $slug_recipe ); // only post name, without "recipe"

        $diets = Taxonomy::get_diets();
        $meals = Taxonomy::get_meals();
        $types = Taxonomy::get_types();
        $tags = Taxonomy::get_tags();

        $this->push_taxonomy(
            $diets,
            $slug_recipe,
            'diets',
            $taxonomy
        );
        $this->push_taxonomy(
            $meals,
            $slug_recipe,
            'meals',
            $taxonomy
        );
        $this->push_taxonomy(
            $types,
            $slug_recipe,
            'types',
            $taxonomy
        );
        $this->push_taxonomy(
            $tags,
            $slug_recipe,
            'tags',
            $taxonomy
        );

        return $taxonomy;

    }

    private function push_taxonomy(array $taxonomy_list, string $recipe_slug, string $taxonomies_array_key, array &$taxonomies_of_post) :void 
    {
        foreach ($taxonomy_list as $taxonomy_element) {
            $posts = $taxonomy_element['posts'];
            $value = $taxonomy_element['name'];

            if( in_array($recipe_slug, $posts) ) {
                array_push($taxonomies_of_post['taxonomy'][$taxonomies_array_key], $value);
            }
        }
    }

    public function parse_markdown(string $raw_content) 
    {

        $converter = new GithubFlavoredMarkdownConverter([
            //'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        //dump($converter->convertToHtml($raw_content)->getContent());

        return $converter->convertToHtml($raw_content)->getContent();
    }

}
