<?php

namespace PhpLab\Sandbox\RestClient\Yii\Web\formatters;

use DOMDocument;

/**
 * Class XmlFormatter
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
class XmlFormatter extends RawFormatter
{

    public function getName(): string
    {
        return 'xml';
    }

    public function format(string $content): string
    {
        $dom = new DOMDocument;
        $dom->formatOutput = true;
        $dom->loadXML($content);
        $xmlContent = $dom->saveXML();
        return $xmlContent;
    }
}