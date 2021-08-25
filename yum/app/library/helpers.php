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


