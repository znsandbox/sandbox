<?php

namespace ZnSandbox\Sandbox\RestClient\Yii\Web\Widgets;

use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\AuthorizationServiceInterface;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use Yii;
use yii\base\Widget;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\EnvironmentServiceInterface;

class FormWidget extends Widget
{

    public $projectId;
    public $model;

    /** @var AuthorizationServiceInterface */
    protected $authorizationService;
    /** @var ProjectServiceInterface */
    protected $projectService;
    /** @var EnvironmentServiceInterface */
    protected $environmentService;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->authorizationService = Yii::$container->get(AuthorizationServiceInterface::class);
        $this->projectService = Yii::$container->get(ProjectServiceInterface::class);
        $this->projectService = Yii::$container->get(ProjectServiceInterface::class);
        $this->environmentService = Yii::$container->get(EnvironmentServiceInterface::class);
    }

    public function run()
    {
        $projectEntity = $this->projectService->oneById($this->projectId);
        return $this->renderFile(__DIR__ . '/../views/request/form/index.php', [
            'model' => $this->model,
            'projectEntity' => $projectEntity,
            'environmentCollection' => $this->environmentService->allByProjectId($projectEntity->getId()),
            'authorization' => $this->authorizationService->allByProjectId($projectEntity->getId(), 'bearer'),
        ]);
    }

}
