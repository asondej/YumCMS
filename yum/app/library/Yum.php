<?php 
declare(strict_types=1);
namespace Library;

use Library\Classes\Taxonomy;
use Library\Classes\Content;
use Library\Classes\Recipe;
use Library\Classes\Page;
use Library\Classes\RecipeFromForm;
use Library\Classes\HomePage;

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

    protected bool $autodelete;
   

    protected string $template = "default";

    public function __construct($show_debug_details = false, $cache = true, $autodelete = false)
    {

        
        $this->slug = $this->getSlug();
        $this->meals = Taxonomy::get_meals();
        $this->diets = Taxonomy::get_diets();
        $this->types = Taxonomy::get_types();
        $this->tags = Taxonomy::get_tags();
        $this->autodelete = $autodelete;

        $this->taxonomy = new Taxonomy($this->slug);
        // own methods
        $this->set_template($this->slug);
        $this->build_template();
        // external methods
        $this->update_taxonomy($cache);

        //$this->taxonomy->list_recipes_in_taxonomy();

        if($this->autodelete) {
            if(Recipe::autodelete($this->autodelete, 60*5)) { // if something was deleted
                $this->update_taxonomy(false);
            }
        }
        
        if($show_debug_details) {
            echo "<div class='noprint'><br>=====<br> slug: ". $this->slug;
            echo "<br>";
            echo "template type: ".$this->template_type;
            echo "<br>";
            echo "template: ".$this->template.'</div>';
        }
        

    }

    protected function update_taxonomy(bool $cache) : void 
    {
        $this->taxonomy->update_meals_json($cache);
        $this->taxonomy->update_taxonomy_json('diets',$cache);
        $this->taxonomy->update_taxonomy_json('types', $cache);
        $this->taxonomy->update_taxonomy_json('tags', $cache);
        $this->taxonomy->taxonomy_generate_links('diets');
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
            $url_parts = array_filter($url_parts);
            if( count($url_parts) > 2) { // if url contains more than 2 parts

                if(end($url_parts) === 'print') {
                    return 'print';
                } else {
                    return "404";
                }
                
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
                
                if(end($url_parts) === 'add') {
                    return "new-recipe";
                }
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
            case ( $this->getSlug() == "new-recipe" ):
                $this->template_type = "new-recipe";
                break;
            case ( $this->getSlug() == "print" ):
                $this->template_type = "print";
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
            case ( Content::is_tax_type( 'meal', $this->getSlug() ) ):
                $this->template_type = "category_like_single";
                break;
            case ( Content::is_tax_type( 'diet', $this->getSlug() ) ):
                $this->template_type = "category_like_single";
                break;
            case ( Content::is_tax_type( 'tag', $this->getSlug() ) ):
                $this->template_type = "tag_like_single";
                break;
            case ( Content::is_tax_type( 'type', $this->getSlug() ) ):
                $this->template_type = "tag_like_single";
                break;
            case ( Content::is_list( $this->getSlug(), 'taglike') ):
                $this->template_type = "tag_like_all";
                break;
            case ( Content::is_list( $this->getSlug(), 'categorylike') ):
                $this->template_type = "category_like_all";
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
                $content = new HomePage();
                //$content = $content->build_homepage_data();
                $content = $content->paginate($this->slug, 12);
                $this->load_this_template($content);
                break;
            case 'new-recipe':
                $sent = false;
                $url = null;
                if(!empty($_POST)) {
                        $newpost = new RecipeFromForm($this->slug, $this->autodelete);
                        if(!empty($_POST['title'])) {
                            $url = 'http://'.$_SERVER['HTTP_HOST'].'/recipe/'. $newpost->slugify($_POST['title']);
                        }
                        $errors = $newpost->validate($_POST);
                        $sent = true;
                        $this->update_taxonomy(false);
                    } else {
                        $errors = [];
                    }
                $this->load_this_template(['meta' =>
                    ["title" => 'New recipe form'],
                    'errors' => $errors,
                    'sent' => $sent,
                    'url' => $url
                    ]);
                break;
            case 'rss':
                # code...
                break;
            case 'page':
                $page = new Page($this->slug);
                $page = $page->getPage();
                $this->load_this_template($page);
                break;
            case 'recipe':
                $recipe = new Recipe($this->slug);
                $recipe = $recipe->getPost($this->slug);
                $this->load_this_template($recipe);
                break;
            case 'print':
                $recipe = new Recipe($this->slug);
                $recipe = $recipe->getPost($this->slug);
                $this->load_this_template($recipe);
                break;
            case 'category_like_single': // meals & diets
                $details = $this->taxonomy->taxonomyPage_single($this->slug);
                $this->load_this_template($details);
                break;
            case 'tag_like_single':
                $details = $this->taxonomy->taxonomyPage_single($this->slug);
                $this->load_this_template($details);
                break;
            case 'category_like_all': // meals & diets
                $details = $this->taxonomy->taxonomyPage_list($this->slug);
                $this->load_this_template($details);
                break;
            case 'tag_like_all':
                $details = $this->taxonomy->taxonomyPage_list($this->slug);
                $this->load_this_template($details);
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

