<?php

namespace ZnSandbox\Sandbox\RestClient\Yii\Api\controllers;

use ZnSandbox\Sandbox\RestClient\Domain\Enums\RestClientPermissionEnum;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use yii\base\Module;
use ZnLib\Rest\Yii2\Base\BaseCrudController;

class FavoriteController extends BaseBookmarkController
{

    public function actionAllByProject($projectId) {
	    return $this->service->allFavoriteByProject($projectId);
    }

}
