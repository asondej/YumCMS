<?php 
declare(strict_types=1);
namespace Library;

use Library\Classes\Taxonomy;
use Library\Classes\Content;
use Library\Classes\Recipe;

class Yum 
{
    protected string $slug;
    protected string $template_type;
    protected object $categories;//?
    protected object $taxonomy;

    protected array $meals;
    protected array $diets;
    protected array $types;
    protected array $tags;
   

    protected string $template = "default";

    public function __construct()
    {

        $this->taxonomy = new Taxonomy();
        $this->slug = $this->getSlug();
        $this->meals = Taxonomy::get_meals();
        $this->diets = Taxonomy::get_diets();
        $this->types = Taxonomy::get_types();
        $this->tags = Taxonomy::get_tags();

        // own methods
        $this->set_template($this->slug);
        $this->build_template();

       $this->taxonomy->update_meals_json();

        echo "<br>=====<br> slug: ". $this->slug;
        echo "<br>";
        echo "template type: ".$this->template_type;

    }

    protected function getSlug() : ?string
    {
        //$query = filter_input(INPUT_SERVER, "REQUEST_URI"); // option for non-apache deployment
        $query = filter_input(INPUT_GET, "request");
        $taxonomies = ["diet","meal","type","tag"] ;

        if ($query === false || $query === null) {
            return "home";
        }
            $url_parts = explode("/", $query);
            

            if( count($url_parts) > 2) { // if url contains more than 2 parts
                return "404";
            } elseif (count($url_parts) === 2 && in_array($url_parts[0], $taxonomies)) {  // taxonomies

                  $match =  match ($url_parts[0]) { 
                        'diet'  => sprintf("diet-%s", $url_parts[1]), 
                        'meal'  => sprintf("meal-%s", $url_parts[1]), 
                        'type'  => sprintf("type-%s", $url_parts[1]), 
                        'tag'   => sprintf("tag-%s", $url_parts[1]),
                        default => "404"
                    };
                    return $match;

            } elseif (count($url_parts) === 2 && $url_parts[0] === "recipe") { //recipes
                return "recipe/".$url_parts[1];
            } elseif ( count($url_parts) === 2 ) { // if not recipe and not taxonony, then oopss...

                return "404";
            }
            else {
                return array_pop($url_parts);
            }

            

            return null; // if something goes wrong
    }

    protected function set_template() : void
    {
        switch(true) {
            case ( $this->getSlug() == "home" ):
                $this->template_type = "home";
                break;
            case ( $this->getSlug() == "feed" ):
                $this->template_type = "rss";
                break;
            case (Content::is_page( $this->getSlug() ) ):
                $this->template_type = "page";
                break;
            case (Content::is_post( $this->getSlug() ) ):
                $this->template_type = "recipe";
                break;
            case ( Content::is_meal( $this->getSlug() ) ):
                $this->template_type = "category_like";
                break;
            case ( Content::is_diet( $this->getSlug() ) ):
                $this->template_type = "category_like";
                break;
            case ( Content::is_tag( $this->getSlug() ) ):
                $this->template_type = "tag_like";
                break;
            case ( Content::is_type( $this->getSlug() ) ):
                $this->template_type = "tag_like";
                break;
            default: 
                $this->slug = "404";
                $this->template_type = "404";
        }

    }

    public function build_template() : void 
    {
        switch ($this->template_type) {
            case 'home':
                $this->load_this_template();
                break;
            case 'rss':
                # code...
                break;
            case 'page':
                # code...
                break;
            case 'recipe':
                $recipe = new Recipe($this->slug);
                $recipe = $recipe->getPost($this->slug);
                 dump($recipe);
                $this->load_this_template($recipe);
                break;
            case 'category_like':
                # code...
                break;
            case 'tag_like':
                # code...
                break;
            
            default:
                $this->load_this_template([]);
                break;
        }
    }

    private function load_this_template(array $page = []) : void {


        $template_path = sprintf('%s/templates/%s/%s.php', ABS_PATH, $this->template, $this->template_type);
        include($template_path);

        
    }
  
}

