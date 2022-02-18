<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Libs\VapeclubKz;

use Symfony\Component\DomCrawler\Crawler;
use ZnCore\Base\Helpers\StringHelper;
use ZnSandbox\Sandbox\Grabber\Domain\Helpers\ParseHelper;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Parsers\ListParserInterface;

class ItemParser implements ListParserInterface
{

    public function parse(string $html)
    {
        $crawler = new Crawler($html);

        $data = [];
        $data['breadcrumbs'] = $this->parseBreadcrumb($crawler);

        $data['price'] = $this->parsePrice($crawler);

//        dd($data);

//        $data['src'] = $crawler->filter('div.image > a.main-image > img')->attr('src');
        $data['mainImageUrl'] = $crawler->filter('a.main-image')->attr('href');
        $data['title'] = $crawler->filter('title')->html();
        $data['shortDescription'] = $crawler->filter('div.short_description > p')->html();
        $data['description'] = $crawler->filter('#tab-description')->html();

        $ogProps = ParseHelper::parseMetaOg($crawler);

        $data['ogProps'] = $ogProps;

        $props = $crawler->filter('ul.list-unstyled > li');

        $attrs = [];

        foreach ($props as $content) {
            $el = new Crawler($content);
            $html = $el->html();
            if ($html !== '0') {
                $html = strip_tags($html);
                $html = StringHelper::removeDoubleSpace($html);
                $html = trim($html, "\n\t\r ");
                //$this->dump($html);

                list($title, $value) = explode(':', $html);
                $attrs[] = [
                    'title' => trim($title),
                    'value' => trim($value),
                ];
            }
        }

        $table = ParseHelper::parseTable($crawler->filter('table.attrbutes'));

        foreach ($table as $row) {
            if (count($row) > 1) {
                $attrs[] = [
                    'title' => $row[0],
                    'value' => $row[1],
                ];
            }
        }

        $data['attrs'] = $attrs;

        $data = $this->prepare($data);

        return $data;
    }

    private function prepare($data) {
        $data['title'] = str_replace(' | Вэйп клаб Казахстан', '', $data['title']);
        return $data;
    }

    private function parsePrice(Crawler $crawler) {
        $price = $crawler->filter('.update_price')->html();
        $isMatch = preg_match('#(([\d\s]+)\s*([^\d]+))#i', $price, $matches);
        if ($isMatch) {
            $amount = StringHelper::removeAllSpace($matches[2]);
            $currency = $matches[3];
            return [
                'amount' => $amount,
                'currency' => $currency,
            ];

//            dd($matches);
        }
        return null;
    }

    private function parseBreadcrumb(Crawler $crawler) {
        return $crawler->filter('ul.breadcrumb a')->each(function (Crawler $crawler, $i) {
//            dd($crawler->html());
            return $crawler->html();
        });
    }
}
