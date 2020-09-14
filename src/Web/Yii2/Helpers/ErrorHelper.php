<?php

namespace ZnSandbox\Sandbox\Web\Yii2\Helpers;

use yii\base\Model;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets\Alert;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\AccessServiceInterface;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\EnvironmentServiceInterface;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use ZnSandbox\Sandbox\RestClient\Yii\Web\models\EnvironmentForm;

class ErrorHelper
{

    public static function handleError(UnprocessibleEntityException $e, Model $model)
    {
        $arr = EntityHelper::collectionToArray($e->getErrorCollection());
        //dd($arr);
        foreach ($arr as $error) {
            if (!empty($error['field'])) {
                $model->addError($error['field'], $error['message']);
            } else {
                \ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets\Alert::create($error['message'], Alert::TYPE_WARNING);
            }
        }
    }

}
