<?php

namespace ZnSandbox\Sandbox\RestClient\Yii\Web\controllers;

use kartik\alert\Alert;
use ZnBundle\User\Domain\Interfaces\Services\IdentityServiceInterface;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnSandbox\Sandbox\RestClient\Domain\Enums\RestClientPermissionEnum;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\AccessServiceInterface;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use ZnSandbox\Sandbox\RestClient\Yii\Web\models\EnvironmentForm;
use Yii;
use yii\base\Module;
use yii2bundle\account\domain\v3\enums\AccountPermissionEnum;
use yii2rails\domain\base\Model;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\EnvironmentServiceInterface;
use RocketLab\Bundle\Web\Helpers\ErrorHelper;

class EnvironmentController extends BaseController
{

    protected $projectService;
    protected $environmentService;

    public function __construct(
        $id, Module $module,
        array $config = [],
        ProjectServiceInterface $projectService,
        EnvironmentServiceInterface $environmentService
    )
    {
        parent::__construct($id, $module, $config);
        $this->projectService = $projectService;
        $this->environmentService = $environmentService;
    }

    public function authentication(): array
    {
        return [
            'create',
            'update',
            'delete',
            'index',
            'view',
        ];
    }

    public function access(): array
    {
        return [
            [
                [RestClientPermissionEnum::PROJECT_READ], ['create', 'update', 'delete'],
            ],
            [
                [RestClientPermissionEnum::PROJECT_READ], ['index', 'view'],
            ],
        ];
    }

    public function actionCreate(int $projectId)
    {
        $projectEntity = $this->projectService->oneById($projectId);
        $model = new EnvironmentForm;
        $model->project_id = $projectId;
        if (Yii::$app->request->isPost) {
            $body = Yii::$app->request->post();
            $model->load($body, 'EnvironmentForm');
            try {
                $this->environmentService->create($model->toArray());
                \App::$domain->navigation->alert->create(I18Next::t('restclient', 'environment.messages.created_success'), Alert::TYPE_SUCCESS);
                return $this->redirect(['/rest-client/project/view', 'id' => $projectEntity->getId()]);
            } catch (UnprocessibleEntityException $e) {
                ErrorHelper::handleError($e, $model);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $environmentEntity = $this->environmentService->oneById($id);
        $model = new EnvironmentForm;
        $model->project_id = $environmentEntity->getProjectId();
        if (Yii::$app->request->isPost) {
            $body = Yii::$app->request->post();
            $model->load($body, 'EnvironmentForm');
            try {
                $this->environmentService->updateById($id, $model->toArray());
                \App::$domain->navigation->alert->create(I18Next::t('restclient', 'environment.messages.updated_success'), Alert::TYPE_SUCCESS);
                return $this->redirect(['/rest-client/project/view', 'id' => $environmentEntity->getProjectId()]);
            } catch (UnprocessibleEntityException $e) {
                ErrorHelper::handleError($e, $model);
            }
        } else {
            $entity = $this->environmentService->oneById($id);
            $model->load(EntityHelper::toArray($entity), '');
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $environmentEntity = $this->environmentService->oneById($id);
        $this->environmentService->deleteById($id);
        \App::$domain->navigation->alert->create(I18Next::t('restclient', 'environment.messages.deleted_success'), Alert::TYPE_SUCCESS);
        return $this->redirect(['/rest-client/project/view', 'id' => $environmentEntity->getProjectId()]);
    }

    /*public function actionView($id)
    {
        $environmentEntity = $this->environmentService->oneById($id);
        return $this->render('view', [
            'environmentEntity' => $environmentEntity,
        ]);
    }*/

}