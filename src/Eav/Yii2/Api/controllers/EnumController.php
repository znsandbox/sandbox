<?php

namespace ZnSandbox\Sandbox\Eav\Yii2\Api\controllers;

use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\CategoryServiceInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\EnumServiceInterface;
use yii\base\Module;
use ZnLib\Rest\Yii2\Base\BaseCrudController;

class EnumController extends BaseCrudController
{

    public function __construct(string $id, Module $module, array $config = [], EnumServiceInterface $bookService)
    {
        parent::__construct($id, $module, $config);
        $this->service = $bookService;
    }
}
