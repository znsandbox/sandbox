<?php

namespace ZnSandbox\Sandbox\RestClient\Yii\Web\controllers;

use common\enums\rbac\PermissionEnum;
use kartik\alert\Alert;
use ZnCore\Base\Domain\Helpers\EntityHelper;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnSandbox\Sandbox\RestClient\Domain\Enums\RestClientPermissionEnum;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use ZnSandbox\Sandbox\RestClient\Yii\Web\models\ProjectForm;
use Yii;
use yii\base\Module;
use yii2bundle\account\domain\v3\enums\AccountPermissionEnum;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\EnvironmentServiceInterface;

class ProjectController extends BaseController
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
                [RestClientPermissionEnum::ACCESS_MANAGE], ['create', 'update', 'delete'],
            ],
            [
                [RestClientPermissionEnum::PROJECT_READ], ['index', 'view'],
            ],
        ];
    }

    public function actionIndex()
    {
        if(Yii::$app->user->can(PermissionEnum::BACKEND_ALL)) {
            $projectCollection = $this->projectService->all();
        } else {
            $projectCollection = $this->projectService->allByUserId(Yii::$app->user->identity->id);
        }
        return $this->render('index', [
            'projectCollection' => $projectCollection,
        ]);
    }

    public function actionView($id)
    {
        $projectEntity = $this->projectService->oneById($id);
        $environmentCollection = $this->environmentService->allByProjectId($id);
        return $this->render('view', [
            'projectEntity' => $projectEntity,
            'environmentCollection' => $environmentCollection,
        ]);
    }

    public function actionCreate()
    {
        $model = new ProjectForm;
        if(Yii::$app->request->isPost) {
            $body = Yii::$app->request->post();
            $model->load($body, 'ProjectForm');
            $this->projectService->create($model->toArray());
            \App::$domain->navigation->alert->create(I18Next::t('restclient', 'project.messages.created_success'), Alert::TYPE_SUCCESS);
            return $this->redirect(['/rest-client/project/index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        $this->projectService->deleteById($id);
        \App::$domain->navigation->alert->create(I18Next::t('restclient', 'project.messages.deleted_success'), Alert::TYPE_SUCCESS);
        return $this->redirect(['/rest-client/project/index']);
    }

    public function actionUpdate($id) {
        $model = new ProjectForm;
        if(Yii::$app->request->isPost) {
            $body = Yii::$app->request->post();
            $model->load($body, 'ProjectForm');
            $this->projectService->updateById($id, $model->toArray());
            \App::$domain->navigation->alert->create(I18Next::t('restclient', 'project.messages.updated_success'), Alert::TYPE_SUCCESS);
            return $this->redirect(['/rest-client/project/index']);
        } else {
            $projectEntity = $this->projectService->oneById($id);
            $model->load(EntityHelper::toArray($projectEntity), '');
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}