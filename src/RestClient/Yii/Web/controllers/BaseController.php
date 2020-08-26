<?php

namespace PhpLab\Sandbox\RestClient\Yii\Web\controllers;

use PhpLab\Core\Exceptions\NotFoundException;
use PhpLab\Sandbox\RestClient\Domain\Entities\ProjectEntity;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

abstract class BaseController extends \RocketLab\Bundle\Web\Base\BaseController
{
    /** @var ProjectServiceInterface */
    protected $projectService;

    protected function getProjectByHash(string $tag): ProjectEntity
    {
        $projectName = $this->projectService->projectNameByHash($tag);
        return $this->getProjectByName($projectName);
    }

    protected function getProjectByName(string $projectName): ProjectEntity
    {
        try {
            $projectEntity = $this->projectService->oneByName($projectName);
            $userId = Yii::$app->user->identity->getId();
            $isAllow = $this->projectService->isAllowProject($projectEntity->getId(), $userId);
            if ( ! $isAllow) {
                throw new ForbiddenHttpException('Project not allow!');
            }
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException('Project not found!');
        }
        return $projectEntity;
    }

}