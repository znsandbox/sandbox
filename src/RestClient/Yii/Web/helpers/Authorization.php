<?php

namespace ZnSandbox\Sandbox\RestClient\Yii\Web\helpers;

use Illuminate\Support\Collection;
use ZnSandbox\Sandbox\RestClient\Domain\Entities\AuthorizationEntity;
use yii2rails\extension\yii\helpers\ArrayHelper;

class Authorization
{

    public static $password = 'Wwwqqq111';

    /**
     * @param Collection | AuthorizationEntity[] $collection
     * @return array
     */
    public static function collectionToOptions(Collection $collection)
    {
        $loginListForSelect = [];
        if ( ! empty($collection)) {
            foreach ($collection as $authorizationEntity) {
                $loginListForSelect[$authorizationEntity->getUsername()] = $authorizationEntity->getUsername();
            }
        }
        $loginListForSelect = ArrayHelper::merge(['' => 'Guest'], $loginListForSelect);
        return $loginListForSelect;
    }

}