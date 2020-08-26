<?php

namespace PhpLab\Sandbox\RestClient\Yii\Api\controllers;

use PhpLab\Sandbox\RestClient\Domain\Enums\RestClientPermissionEnum;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use yii\base\Module;
use RocketLab\Bundle\Rest\Base\BaseCrudController;

class HistoryController extends BaseBookmarkController
{

    public function actionAllByProject($projectId) {
	    return $this->service->allHistoryByProject($projectId);
    }

    public function actionAddToFavorite() {
        $this->service->addToCollection(\Yii::$app->request->post('hash'));
    }
}
