<?php

namespace ZnSandbox\Sandbox\Eav\Yii2\Api\controllers;

use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\CategoryServiceInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\MeasureServiceInterface;
use yii\base\Module;
use ZnLib\Rest\Yii2\Base\BaseCrudController;

class UnitController extends BaseCrudController
{

    public function __construct(string $id, Module $module, array $config = [], MeasureServiceInterface $bookService)
    {
        parent::__construct($id, $module, $config);
        $this->service = $bookService;
    }
}
