<?php

namespace PhpLab\Sandbox\RestClient\Yii\Api\controllers;

use PhpLab\Sandbox\RestClient\Domain\Enums\RestClientPermissionEnum;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use yii\base\Module;
use RocketLab\Bundle\Rest\Base\BaseCrudController;

class ProjectController extends BaseCrudController
{

	public function __construct(
	    string $id,
        Module $module,
        array $config = [],
        ProjectServiceInterface $projectService
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $projectService;
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
                [RestClientPermissionEnum::PROJECT_WRITE], ['create', 'update', 'delete'],
            ],
            [
                [RestClientPermissionEnum::PROJECT_READ], ['index', 'view'],
            ],
        ];
    }

}