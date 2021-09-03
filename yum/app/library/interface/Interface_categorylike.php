<?php 
declare(strict_types=1);

namespace Library\Interface;

interface Interface_categorylike {
    public static function get_all(string $taxonomy, bool $popular_sort = false) : array;
}