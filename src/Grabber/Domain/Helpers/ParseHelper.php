<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Helpers;

use DOMAttr;
use Symfony\Component\DomCrawler\Crawler;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class ParseHelper
{

    public static function parseTable(Crawler $crawler): array
    {
        return $crawler->filter('tr')->each(function ($tr, $i) {
            return $tr->filter('td')->each(function ($td, $i) {
                return trim($td->text());
            });
        });
    }

    /**
     * @param Crawler $crawler
     * @return array
     * @deprecated
     * @see parseMeta
     */
    public static function parseMetaOg(Crawler $crawler): array
    {
        return $crawler->filter('meta[property]')->each(function (Crawler $crawler, $i) {
            $property = $crawler->attr('property');
            return [
                'property' => str_replace('og:', '', $property),
                'content' => $crawler->attr('content'),
            ];
        });
    }

    public static function parseMetaInfo(Crawler $crawler): array
    {
        return $crawler->filter('meta')->each(function (Crawler $crawler, $i) {
            $node = $crawler->getNode(0);
            $attrs = [];
            /** @var DOMAttr $attribute */
            foreach ($node->attributes as $attribute) {
                $attrs[$attribute->name] = $attribute->value;
            }
            $attrs['html'] = $crawler->outerHtml();
            return $attrs;
        });
    }

    public static function parseMeta(Crawler $crawler): array
    {
        $propertyArray = self::parseMetaInfo($crawler);

        $map = [];
        foreach ($propertyArray as $i => $item) {
            if (isset($item['property'])) {
                $propertyPath = str_replace(':', '.', $item['property']);
                ArrayHelper::setValue($map, 'property.' . $propertyPath, $item['content']);
            } elseif (isset($item['name'])) {
                $propertyPath = str_replace(':', '.', $item['name']);
                ArrayHelper::setValue($map, 'name.' . $propertyPath, $item['content']);
            } else {
//                ArrayHelper::setValue($map, ['misc', $i], $item);
            }
        }

        $map['all'] = $propertyArray;

//        ArrayHelper::setValue($map, 'misc', array_values(ArrayHelper::getValue($map, 'misc', [])));

        return $map;
    }

    public static function parseTitle(Crawler $crawler): string
    {
        return $crawler->filter('title')->html();
    }
}
