<?php 
declare(strict_types=1);

namespace Library\Classes;

class HomePage {

    protected function get_all_recipes() : array
    {
        $recipes_values = Recipe::list_all_recipes(true);
        $recipes_keys = Recipe::list_all_recipes(false, true);
        $recipes = array_combine($recipes_keys, $recipes_values);

        foreach($recipes as $path=>$details) {
            
            $slug = explode('/', $details)[1];

            $recipe = new Recipe('recipe/'.$slug);
            $recipe = $recipe->getPost();
            unset($recipe['content']);

            $recipes[$path] = [
                'url' => 'http://'.$_SERVER['SERVER_NAME']. '/recipe/'.$slug. '/',
                'details' => $recipe
            ];

            $recipes[$recipes[$path]['details']['meta']['title']] = $recipes[$path];
            unset($recipes[$path]);

        }

        return $recipes;
    }

    public function build_homepage_data() : array 
    {

        $page = [
            'meta' => [
                "title" => 'All recipes'
            ],

            'recipes' => $this->get_all_recipes(),
        ];


        return $page;

    }

    public function paginate(string $slug, int $howMany = 10) : array
    {
        $recipes = $this->build_homepage_data();


        $paginated_array = [
            'meta' => $recipes['meta'],
            'recipes' => [],
        ];

        $numer_of_pages = ceil( count($recipes['recipes']) / $howMany );
        $pages =  $current =  $active =  $prev =  $next = '';
  
        if(!isset($_GET['page'])) {
            $paginated_array['recipes'] = array_slice($recipes['recipes'], 0, $howMany , true);
            $current = 1;
            $prev = '';
        } else {
            $paginated_array['recipes'] = array_slice($recipes['recipes'], $howMany*$_GET['page']-$howMany, $howMany , true);
            $current = $_GET['page'];
            $prev = ' <a class="page-link" href="?page='.$current - 1 .'" aria-label="prev">
            <span aria-hidden="true"><i class="fa fa-angle-left"></i></span>
            <span class="sr-only">prev</span></a></li>';
        }


        for($i=1; $i<=$numer_of_pages; $i++) {

            if(isset($_GET['page']) && $_GET['page']  == $i) {
                $active = 'active';
            } else {
                $active = '';
            }


            if ( ( isset($_GET['page']) && $_GET['page']  == 1 ) && $i == 1 || !isset($_GET['page'])  && $i == 1 ) {
                //$pages .= '';
                $pages .= '<li class="page-item active "><a class="page-link">'.$i.'</a></li>';
                continue;
            }

            
            if ($i == 1) {
                $pages .= '<li class="page-item '.$active.' "><a class="page-link" href="'. 'http://'.$_SERVER['SERVER_NAME'] .'">'.$i.'</a></li>';
            } else {
                $pages .= '<li class="page-item '.$active.' "><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
            }

            if(isset($_GET['page']) && $_GET['page']  == 1) {
                $prev = '';
            }

            if (isset($_GET['page']) && $_GET['page']  == $numer_of_pages) {
                $next = '';
            } else {
                $next = '<li class="page-item">
                <a class="page-link" href="?page='.$current + 1 .'" aria-label="Next">
                    <span aria-hidden="true"><i class="fa fa-angle-right"></i></span>
                    <span class="sr-only">Next</span>
                </a>
                </li>';
            }
            
        }

        if($numer_of_pages > 1) {

            $html = '<nav class="pagination">
            <ul class="pagination">
                <li class="page-item">
                '.$prev.
                $pages.
                $next.'
            </ul>
            </nav>';
        } 


        $paginated_array['pagination'] = $html; 


        return $paginated_array;
    }


}