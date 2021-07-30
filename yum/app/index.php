<?php 
declare(strict_types=1);

include_once("debug/debug.php"); 

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/library/helpers.php');
// require_once(__DIR__ . '/library/yum.php');
// require_once(__DIR__ . '/library/classes/taxonomy.php');
// require_once(__DIR__ . '/library/classes/content.php');
// require_once(__DIR__ . '/library/interface/interfacePost.php');
// require_once(__DIR__ . '/library/interface/interfaceCategory_like.php');
// require_once(__DIR__ . '/library/interface/interfaceTag_like.php');
// require_once(__DIR__ . '/library/classes/recipe.php');


use Library\Yum;
$yum = new Yum();
//$yum->build_template();

/*
//TODO: 
- move everything except recipes to "app" folder ✔️
    - change paths accordingly ✔️
    - change namespaces (?)
- make class for meta
- read information about meal from folders not files
- write information about meal to file (?) - yes, that would be helpfull for showing meals page
- read information about rest of the taxonomies from.md files, not taxaonomy jsons
- write information abot rest of the taxonomies from md. files to json files (on every app execution?)

### ^^^ taxonomy class: create methods that scans folder (for meals) and recipe .md files (for other taxonomies) and make changes in respective taxonomy files

*/

use Library\Classes\Taxonomy;
use Library\Classes\Content;
use Library\Classes\Recipe;




//debug(Taxonomy::get_diets());




// dump(filter_input(INPUT_GET, "request"), "filtrowanie");

