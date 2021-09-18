<?php 
declare(strict_types=1);

use Library\Classes\Taxonomy;
use Library\Classes\CategoryLike;
use Library\Classes\TagLike;

function generate_tax_menu( string $taxonomy, $class = "dropdown-item") : string 
{
    return Taxonomy::taxonomy_generate_links($taxonomy, $class, ['uppercase'=> true]);
}

function template_path( string $template_name = 'default') : string 
{
    return 'http://'.$_SERVER['SERVER_NAME']. '/app/templates/'.$template_name. '/';
}
function homepage_url() : string
{
    return 'http://'.$_SERVER['SERVER_NAME'];
}

function tax_list_url(string $taxonomy) : string
{
        return Taxonomy::tax_list_url($taxonomy);
}


function get_taxonomy_icon(string $taxonomy, string $value) : string 
{
    $class = match ($value) {
        'dinner' => "$taxonomy dinner",
        'breakfast' => "$taxonomy breakfast",
        'lunch' => "$taxonomy lunch",
        'evening snack' => "$taxonomy snack",
        'supper' => "$taxonomy supper",
        'dessert' => "$taxonomy dessert",
        'vege' => "$taxonomy vege",
        'pescovege' => "$taxonomy pescovege",
        'with meat' => "$taxonomy meat",
        default => ''
    };
    return $class;
}

function get_taxonomy(array $taxonomy_values, string $taxonomy_slug = '', string $separator = ', ', $asLink = true) : string
{
    $list = '';
    $last = count($taxonomy_values);
    $i = 0;

    if(!array_key_exists(0, $taxonomy_values)) { // if array is assoc
        
        foreach ($taxonomy_values as $value=>$link) {
            $i++;
            if ($i >= $last) { 
                if($asLink) {
                    $list.='<a href="'.$link.'">'.$value.'</a>';
                } else {
                    $list.=$value.$separator;
                }           
            } else {
                if($asLink) {
                    $list.='<a href="'.$link.'">'.$value.'</a>'.$separator;
                } else {
                    $list.=$value.$separator;
                }        
            }
        }

    } else {

        $link = 'http://'.$_SERVER['SERVER_NAME'].'/'.$taxonomy_slug.'/';
        foreach ($taxonomy_values as $value) {
            $slug = str_replace(' ', '-', $value);
            $i++;
            if ($i >= $last) { 
                if($asLink) {
                    $list.='<a href="'.$link.$slug.'">'.$value.'</a>';
                } else {
                    $list.= $value.$separator;
                }           
            } else {
                if($asLink) {
                    $list.='<a href="'.$link.$slug.'">'.$value.'</a>'.$separator;
                } else {
                    $list.= $value.$separator;
                }        
            }
        }

    }
   

    return $list;

}

function show_popular_tags(int $howmany = 8, array $open_close = ['<li class="list-inline-item"><a href="%s">', '</a></li>']) : string 
{
    $tags_array = tagLike::get_popular('tag', $howmany);
  
    $html = '';

    foreach ($tags_array as $name=>$url) {
        $open = sprintf($open_close[0], $url);
        $close = $open_close[1];
        $html.= "$open$name$close";
    }

    return $html;
}

function show_types(int $howmany = 8, array $open_close = ['<li class="list-inline-item"><a href="%s">', '</a></li>']) : string 
{
    $tags_array = tagLike::get_all_with_url('type');
    $html = '';
    $i = 0;

    foreach ($tags_array as $name=>$url) {
        $i++; if( $i <=  $howmany) {
        $open = sprintf($open_close[0], $url); 
        $close = $open_close[1];
        $html.= "$open$name$close";
        }
    }

    return $html;
}

function show_diets (array $open_close = ['<li><a href="%s" class="%s">','<span class="float-right">(%s)</span></a></li>']) : string 
{
    $html = '';
    $diets = CategoryLike::get_all('diet', true);

    foreach($diets as $diet=>$postsNumber) {
        $url = 'http://'.$_SERVER['SERVER_NAME'].'/diet/'.Taxonomy::taxonomy_to_slug($diet);
        $diet = str_replace('-', ' ', $diet);
        $value = get_taxonomy_icon('diet', $diet);
        $open = sprintf($open_close[0], $url, $value);
        $close = sprintf($open_close[1], $postsNumber);
        $html.= $open.$diet.$close;
    }
    
    return $html;
}

function show_meals (array $open_close = ['<li><a href="%s" class="%s">','<span class="float-right">(%s)</span></a></li>']) : string 
{
    $html = '';
    $meals = CategoryLike::get_all('meal', true);

    foreach($meals as $meal=>$postsNumber) {
        $url = 'http://'.$_SERVER['SERVER_NAME'].'/meal/'.Taxonomy::taxonomy_to_slug($meal);
        $meal= str_replace('-', ' ', $meal);
        $value = get_taxonomy_icon('meal', $meal);
        $open = sprintf($open_close[0], $url, $value);
        $close = sprintf($open_close[1], $postsNumber);
        $html.= $open.$meal.$close;
    }
    
    return $html;
}

function formAutocomplete(string $name) : ?string 
{
    if(!empty($_POST) && isset($_POST[$name]) ) {
        return $_POST[$name];
    }
    return null;
}

function selectAutocomplete(string $name, string $value): string
{

    if (isset($_POST[$name]) ) {
        if ($_POST[$name] == $value) { // present in post and match the value
            return 'selected';
        } else {
            return '';
        }
    } elseif ($value === '') { // not present in post and is placeholder value
        return 'selected';
    }
    return '';  
    
}

function validationInfo (array $page, string $name, string $type = 'text') : string
{
    $txt = '';
    
    if(isset($page['errors']) && in_array($name, $page['errors']) ) {

        if ($type === 'class') {
            $txt = ' input-error';
        } else {
            $txt = '<span class="error">this field is required</span>';
        }
        
   }
   
   return $txt;
   
}

