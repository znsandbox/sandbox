<?php

namespace ZnSandbox\Sandbox\RestClient\Yii\Web\helpers;

use Illuminate\Support\Collection;
use ZnSandbox\Sandbox\RestClient\Domain\Entities\BookmarkEntity;
use yii2rails\extension\yii\helpers\ArrayHelper;

class CollectionHelper
{

    /**
     * @param Collection | BookmarkEntity[] $collection
     * @return array
     */
    public static function prependCollection(Collection $collection)
    {
        $closure = function (BookmarkEntity $row) {
            $pureUri = ltrim($row->getUri(), '/');
            if (preg_match('|[^/]+|', $pureUri, $matches)) {
                return $matches[0];
            } else {
                return 'common';
            }
        };
        $collection = ArrayHelper::group($collection, $closure);
        return $collection;
    }

}