<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Libs\VapeclubKz;

use Symfony\Component\DomCrawler\Crawler;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Parsers\ListParserInterface;

class ListParser implements ListParserInterface
{

    public function parse(string $html)
    {
        $crawler = new Crawler($html);
        $links = $crawler->filter('.products_category .product-layout')->each(function (Crawler $crawler, $i) {
            return $crawler->filter('.product-thumb .image a')->attr('href');
        });
        return $links;
    }
}
