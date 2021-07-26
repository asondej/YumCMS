<?php 
declare(strict_types=1);

include_once("debug/debug.php"); 

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/library/yum.php');
require_once(__DIR__ . '/library/classes/taxonomy.php');
require_once(__DIR__ . '/library/classes/content.php');
//dump(__NAMESPACE__);
use Library\Yum;
$yum = new Yum();

use Library\Classes\Taxonomy;
use Library\Classes\Content;
//debug(Taxonomy::get_diets());




// dump(filter_input(INPUT_GET, "request"), "filtrowanie");

