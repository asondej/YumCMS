<?php 
declare(strict_types=1);

use Library\Classes\Taxonomy;

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

function get_taxonomy(array $taxonomy_values, string $separator = ', ', $asLink = true) : string
{

    $list = '';
    $last = count($taxonomy_values);
    $i = 0;
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

    return $list;

}

