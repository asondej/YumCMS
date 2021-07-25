<?php 
declare(strict_types=1);

include_once("debug/debug.php"); 

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/library/yum.php');
require_once(__DIR__ . '/library/classes/category.php');

use Library\Yum;
$yum = new Yum();

// class Point {
//     public int|float|string $number;
//     public function __construct(
//       public float $x = 1.0,
//       protected float $y = 2,
//       public string $z = "lorem",
//     ) {
//         echo $this->z;
//     }
//   }

  echo match (8.0) {
    '8.0'   => "Oh no!",
    8.0     => "This is what I expected",
  };

//   $test = new Point();
//   dump($test->x);

dump($yum);

// dump(data:$_GET, comment: "GET");

print_r(get_debug_type($yum)) ;

// dump($_REQUEST);

// dump(filter_input(INPUT_GET, "request"), "filtrowanie");

