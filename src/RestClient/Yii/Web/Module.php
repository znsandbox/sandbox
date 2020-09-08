<?php

namespace ZnSandbox\Sandbox\RestClient\Yii\Web;

use Yii;
use ZnSandbox\Sandbox\RestClient\Domain\Enums\RestClientPermissionEnum;
use yii\filters\AccessControl;

class Module extends \yii\base\Module
{

    public $defaultRoute = 'request';

    public $formatters = [
        'application/json' => 'ZnSandbox\Sandbox\RestClient\Yii\Web\formatters\JsonFormatter',
        'application/xml' => 'ZnSandbox\Sandbox\RestClient\Yii\Web\formatters\XmlFormatter',
        'text/html' => 'ZnSandbox\Sandbox\RestClient\Yii\Web\formatters\HtmlFormatter',
    ];

    public function behaviors()
    {
        return [
            'as access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [RestClientPermissionEnum::PROJECT_READ],
                    ],
                ],
            ]
        ];
    }

}
