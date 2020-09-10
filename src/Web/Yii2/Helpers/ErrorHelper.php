<?php

namespace ZnSandbox\Sandbox\Web\Yii2\Helpers;

use ZnBundle\User\Domain\Interfaces\Services\IdentityServiceInterface;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\AccessServiceInterface;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use ZnSandbox\Sandbox\RestClient\Yii\Web\models\EnvironmentForm;
use ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets\Alert;
use Yii;
use yii\base\Module;
use yii2bundle\account\domain\v3\enums\AccountPermissionEnum;
use yii\base\Model;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\EnvironmentServiceInterface;

class ErrorHelper
{

    public static function handleError(UnprocessibleEntityException $e, Model $model) {
        $arr = EntityHelper::collectionToArray($e->getErrorCollection());
        //dd($arr);
        foreach ($arr as $error) {
            if(!empty($error['field'])) {
                $model->addError($error['field'], $error['message']);
            } else {
                \App::$domain->navigation->alert->create($error['message'], Alert::TYPE_WARNING);
            }
        }
    }

}
