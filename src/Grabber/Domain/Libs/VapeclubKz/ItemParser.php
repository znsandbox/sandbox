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

        $ogProps = ParseHelper::parseMeta($crawler);
        
        $data['sourceUrl'] = $ogProps['property']['og']['url'];
        
        $data['breadcrumbs'] = $this->parseBreadcrumb($crawler);
        
        if (count($data['breadcrumbs']) > 1) {
            $data['categoryTitle'] = $data['breadcrumbs'][1];
        }
        
        //dd($data);

        $data['price'] = $this->parsePrice($crawler);
//        $data['src'] = $crawler->filter('div.image > a.main-image > img')->attr('src');
        $data['mainImageUrl'] = $crawler->filter('a.main-image')->attr('href');
        $data['title'] = $crawler->filter('title')->html();
        if($crawler->filter('div.short_description')->count()) {
            $data['shortDescription'] = strip_tags($crawler->filter('div.short_description')->html());
        }
        $data['description'] = $crawler->filter('#tab-description')->html();

        //$data['ogProps'] = ParseHelper::parseMetaOg($crawler);
        $data['attributes'] = $this->parseAttributes($crawler);

        $data = $this->prepare($data);

        return $data;
    }

    private function makeToken($title): string
    {
        $title = mb_strtolower($title);
        $title = StringHelper::removeDoubleSpace($title);
        $title = trim($title);
        return $title;
    }

    private function prepare($data)
    {
        $data['title'] = str_replace('Вэйп клаб Казахстан', '', $data['title']);
        $data['title'] = str_replace('Вейп клаб Казахстан', '', $data['title']);
        $data['title'] = StringHelper::removeDoubleSpace($data['title']);
        $data['title'] = trim($data['title'], ' |');
        $data['title'] = strip_tags($data['title']);

        $assoc = [
            'manufacturer' => 'Производитель',
            'model' => 'Модель',
            'class' => 'Класс',
            'nicotine' => 'Содержание никотина',
            'taste' => 'Вкус',
            'tasteList' => 'Со вкусами',
            'volume' => 'Объем',
            'composition' => 'Состав',
            'bottleType' => 'Флакон',
            'countryOfOrigin' => 'Страна производства',
        ];
        foreach ($assoc as $name => $title) {
            $assoc[$name] = self::makeToken($title);
        }

        $assocFlip = array_flip($assoc);

//        dd($assoc);

        foreach ($data['attributes'] as &$attribute) {
            $title = self::makeToken($attribute['title']);
            if (isset($assocFlip[$title])) {
                $attribute['name'] = $assocFlip[$title];
            }
        }
        // dd($data['attributes']);
        return $data;
    }

    private function parseAttributes(Crawler $crawler)
    {
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

               
                $items = explode(':', $html);
                if(count($items) > 1) {
                    list($title, $value) = $items;
                } else {
                    list($title, $value) = $html;
                }
                
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
        return $attrs;
    }

    private function parsePrice(Crawler $crawler)
    {
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

    private function parseBreadcrumb(Crawler $crawler)
    {
        return $crawler->filter('ul.breadcrumb a')->each(function (Crawler $crawler, $i) {
//            dd($crawler->html());
            return $crawler->html();
        });
    }
}
