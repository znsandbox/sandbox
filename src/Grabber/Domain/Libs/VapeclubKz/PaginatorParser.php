<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Libs\VapeclubKz;

use Symfony\Component\DomCrawler\Crawler;
use ZnSandbox\Sandbox\Grabber\Domain\Dto\ListDto;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Parsers\ListParserInterface;

class PaginatorParser implements ListParserInterface
{

    public function parse(string $html)
    {
        $crawler = new Crawler($html);
        $pages = $crawler->filter('.pagination li')->each(function (Crawler $crawler, $i) {
            return $crawler->filter('*')->eq(0)->innerText();
        });
        foreach ($pages as $i => $page) {
            if (!is_numeric($page)) {
                unset($pages[$i]);
            }
        }
        return $pages;
    }
}
