<?php 
declare(strict_types=1);

function template_path( string $template_name = 'default') : string 
{
    return 'http://'.$_SERVER['SERVER_NAME']. '/app/templates/'.$template_name. '/';
}


