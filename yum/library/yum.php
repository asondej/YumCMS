<?php 
declare(strict_types=1);

namespace Library;

class Yum 
{
    protected $slug;

    public function __construct()
    {
        $this->slug = $this->getSlug();
        //echo $this->slug;
    }

    protected function getSlug(): ?string
    {
        //$query = filter_input(INPUT_SERVER, "REQUEST_URI"); // option for non-apache deployment
        $query = filter_input(INPUT_GET, "request"); // option for non-apache deployment

        if ($query === false || $query === null) {
            return "home";
        }
            $url_parts = explode("/", $query);
            if( count($url_parts) > 2) { // if url contains more than 2 parts
                return "404";
            } elseif (count($url_parts) === 2) { // this can be meal, type, diet or tag

                    match ($url_parts[0]) {
                        'diet'  => printf("diet-%s", $url_parts[1]), 
                        'meal'  => printf("meal-%s", $url_parts[1]), 
                        'type'  => printf("type-%s", $url_parts[1]), 
                        'tag'   => printf("tag-%s", $url_parts[1]),
                    };

            } else {
                return array_pop($url_parts);
            }
            return null; // if something goes wrong
    }
  
}

