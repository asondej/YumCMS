<?php 
declare(strict_types=1);

function template_path( string $template_name = 'default') : string 
{
    return 'http://'.$_SERVER['SERVER_NAME']. '/templates/'.$template_name. '/';
}


//function 


// function  meal_get_link(string $name) : string
// {
//     return 'http://'.$_SERVER['SERVER_NAME']. '/meals/'.$name. '/';
// }

//dump(meal_get_link('breakfast'), 'tu jestesmy');