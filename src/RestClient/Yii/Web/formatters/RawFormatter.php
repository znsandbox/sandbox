<?php

namespace ZnSandbox\Sandbox\RestClient\Yii\Web\formatters;

use yii\base\ErrorException;
use yii\base\InvalidArgumentException;

/**
 * Class RawFormatter
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
class RawFormatter
{

    public function getName(): string
    {
        return 'raw';
    }

    /**
     * @param string $content
     * @return string
     * @throws ErrorException
     * @throws InvalidArgumentException
     */
    public function format(string $content): string
    {
        return $content;
    }

}