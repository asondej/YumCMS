<?php 
declare(strict_types=1);

namespace Library\Interface;

interface Interface_taglike {
    public static function get_all(string $taxonomy) : array;
    public static function get_all_with_url(string $taxonomy) : array; 
}