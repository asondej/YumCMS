<?php 
declare(strict_types=1);

namespace Library\Classes;

use League\CommonMark\GithubFlavoredMarkdownConverter;

class Page {

    private string $slug;

    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    public function getPage() : array {
        $page = [];

        $content_raw = file_get_contents(ABS_PATH.'/content/page/'.$this->slug);
        $content_raw = explode('===', $content_raw );
        $converter = new GithubFlavoredMarkdownConverter(['allow_unsafe_links' => false,]);

        $meta = json_decode($content_raw[0], true);

        $page['type'] = 'page';
        $page['meta'] = $meta;
        $page['content'] = $converter->convertToHtml(end($content_raw))->getContent();

        return $page;
    }
}