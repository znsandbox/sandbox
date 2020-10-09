<?php

namespace ZnSandbox\Sandbox\Eav\Yii2\Api\controllers;

use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\CategoryServiceInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\AttributeServiceInterface;
use ZnSandbox\Sandbox\Eav\Domain\Services\AttributeService;
use yii\base\Module;
use ZnLib\Rest\Yii2\Base\BaseCrudController;

class AttributeController extends BaseCrudController
{

    public function __construct(string $id, Module $module, array $config = [], AttributeServiceInterface $bookService)
    {
        parent::__construct($id, $module, $config);
        $this->service = $bookService;
    }
}
