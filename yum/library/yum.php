<?php 
declare(strict_types=1);
namespace Library;

use Library\Classes\Taxonomy;
use Library\Classes\Content;
use Library\Classes\Recipe;

class Yum 
{
    protected string $slug;
    protected array $meals;
    protected array $diets;
    protected array $types;
    protected array $tags;
    protected $template_type;

    public function __construct()
    {
        $this->slug = $this->getSlug();
        $this->meals = Taxonomy::get_meals();
        $this->diets = Taxonomy::get_diets();
        $this->types = Taxonomy::get_types();
        $this->tags = Taxonomy::get_tags();

        $this->set_template($this->slug);
        echo "slug: ". $this->slug;
        echo "<br>";
        echo "template: ".$this->template_type;

        $recipe = new Recipe();
        $recipe->getPost($this->slug);

       //debug(Content::is_diet($this->slug));

    }

    protected function getSlug(): ?string
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
                    //dump(sprintf("diet-%s", $url_parts[1]));
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

    protected function set_template(string $slug): void
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
                dump("sprawdzanie czy jest postem");
                dump($this->getSlug());
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
                $this->template_type = "page";
        }

    }

    public function build_template() :void
    {
        
    }
  
}

