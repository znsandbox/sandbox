<?php

namespace PhpLab\Sandbox\RestClient\Yii\Api\controllers;

use PhpLab\Sandbox\RestClient\Domain\Enums\RestClientPermissionEnum;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use yii\base\Module;
use RocketLab\Bundle\Rest\Base\BaseCrudController;

class FavoriteController extends BaseBookmarkController
{

    public function actionAllByProject($projectId) {
	    return $this->service->allFavoriteByProject($projectId);
    }

}
