<?php 
declare(strict_types=1);
namespace Library\Classes;

// include ABS_PATH . 'library/classes/interface/interfacePost.php';

use League\CommonMark\GithubFlavoredMarkdownConverter;
use League\CommonMark\CommonMarkConverter;

class Recipe
{
    private string $slug;
    private string $file_name;

    public function __construct(string $slug) 
    {
        $this->slug = $slug;

        $slug_recipe = explode("/", $this->slug);
        $slug_recipe = array_pop($slug_recipe); // only post name, without "recipe"
        $this->file_name = $slug_recipe;
    }

    public function getPost(): ?array
    {
    
        $path = $this->get_post_file_path();
        dump($path);
        
        $post_raw = file_get_contents($path); 
        $post_raw = $this->split_raw($post_raw);  
        
        //dump($post_raw);

        $post_meta = $post_raw[0];
        $post_content_raw = $post_raw[1];

        $post = [
            "meta" => [
                "title" => json_decode($post_meta, true)["title"],
                "slug" => $this->file_name,
                "image" => json_decode($post_meta, true)["image"],
            ],
            'taxonomy' => [
                'meals' => $this->get_post_file_path(true),
                'diets' => $this->get_post_diet(),
                'types' => $this->get_post_taglike_taxonomies('types'),
                'tags' => $this->get_post_taglike_taxonomies('tags'),
            ],
            "content" => $this->parse_markdown($post_content_raw),
        ];

        $post = array_merge($this->get_taxonomy($this->slug), $post);
      
        //dump($this->get_post_diet());
        dump($this->get_post_taglike_taxonomies('tags'));
     
        return $post;

    }

    private function get_post_diet() : string
    {
        
        $post_parts = $this->post_parts_array();
        $diet = $post_parts[2];
        //$pattern = '/(\b\w*\s*\w+\s+\w*\b)\s*(\[.*x.*\])/';
        $pattern = '/(\b\w*\s*\w+\b)\s*(\[.*x.*\])/';
        $matches = '';
        if(stripos($diet, "diet") ) {

            preg_match($pattern, $diet, $matches);
            $diet = $matches[1] ?? '';
            return $diet;
        }

    }

/*
* string $type [post, category, product]
*/
    ## type values: 'tags' | 'types'
    private function get_post_taglike_taxonomies(string $type) : array
    {
        $post_parts = $this->post_parts_array();
        if( $type === 'tags') {
            $index = 3;
        } elseif ($type === 'types') {
            $index = 4;
        }
        $tax = $post_parts[$index]; 
        $tags_array = []; 
       $tags_array = preg_grep('/([^,\n]+)/', explode("\n", $tax));
       if(stripos($tags_array[0], 'tags') || stripos($tags_array[0], 'type')) {
        $tags_array = explode(',', $tags_array[1]);
       }

       $tags_array = array_map(function($value) {
           //dump($value);
           $value = trim($value); 
           return $value;
       },$tags_array);

       $tags_array = array_filter($tags_array);
    //    $tags_array = array_filter($tags_array, function($value, $key) {
    //     return $value != '';
    //    }, ARRAY_FILTER_USE_BOTH);

        return $tags_array;
    }

    private function post_parts_array() :array 
    {
        $path = $this->get_post_file_path();
        $post_content = file_get_contents($path);
        $post_parts = $this->split_raw($post_content);
        return $post_parts;
    }

    private function split_raw(string $raw_content) : array
    {
        return preg_split('/\s+={3,}\s+/', $raw_content);
    }

    private function get_post_file_path(bool $folder_only = false) : ?string
    {


        $all_posts =  $this->list_all_recipes(); 
        $all_posts_names = array_map(function($value) {
            
            $elements = explode("/", $value);
            $filename = $elements[1];
            $value = $filename;
            return $value;

        }, $all_posts);

        

        if ( in_array( $this->file_name, $all_posts_names) ) { 
            $index_in_allPost_list = array_search($this->file_name, $all_posts_names);
            $path = $all_posts[$index_in_allPost_list];
            // debug(data: $this->file_name);
            // debug(data: $all_posts_names);
            if($folder_only) {
                $elements = explode("/", $path);
                $folder_name = explode("_", $elements[0]);
                $meal_value = $folder_name[1];
                return $meal_value;
            }

            return $_SERVER["DOCUMENT_ROOT"].'/recipes/'.$path.'.md';
    
        } else {
            return null;
        }

    }

    public static function post_exist(string $slug) : bool
    {
        $slug_name = explode("/", $slug);
        $slug_name = array_pop($slug_name); // only post name, without "recipe"
        $all_posts =  self::list_all_recipes();
       
        $all_posts_names = array_map(function($value) {
            $elements = explode("/", $value); 
            $filename = $elements[1];
            $value = $filename;
            return $value;

        }, $all_posts);

        if ( in_array( $slug_name, $all_posts_names) ) {
            return true;
        } else {
            return false;
        }
    }

    public static function list_all_recipes(bool $folder_as_category = false) : array
    {
        $recipes_folder = $_SERVER["DOCUMENT_ROOT"].'/recipes/';
        $all_posts = glob($recipes_folder."*/*.md", GLOB_BRACE);
        $all_posts = array_map(function($value) use ($folder_as_category, $recipes_folder) {
            $value = str_replace($recipes_folder, "", $value);
            $value = str_replace(".md", "", $value);
            if( $folder_as_category ) { // get rid of number prefix
                $value = explode("_", $value);
                $value = $value[1];
            }
            return $value;
        }, $all_posts);
        return $all_posts;
    }
    
    private function get_taxonomy() : ?array //TODO: is this still necessary?
    {

        $taxonomy = [ 'taxonomy' => [
            'meals' => [],
            'diets' => [],
            'types' => [],
            'tags' => [],
            ]
        ];

        $diets = Taxonomy::get_diets();
        $meals = Taxonomy::get_meals();
        $types = Taxonomy::get_types();
        $tags = Taxonomy::get_tags();

        $this->push_taxonomy(
            $diets,
            $this->file_name,
            'diets',
            $taxonomy
        );
        $this->push_taxonomy(
            $meals,
            $this->file_name,
            'meals',
            $taxonomy
        );
        $this->push_taxonomy(
            $types,
            $this->file_name,
            'types',
            $taxonomy
        );
        $this->push_taxonomy(
            $tags,
            $this->file_name,
            'tags',
            $taxonomy
        );

        return $taxonomy;

    }

    private function push_taxonomy(array $taxonomy_list, string $recipe_slug, string $taxonomies_array_key, array &$taxonomies_of_post) :void //TODO: is this still necessary?
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
