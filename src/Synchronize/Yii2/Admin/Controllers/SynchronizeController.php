<?php

namespace ZnSandbox\Sandbox\Synchronize\Yii2\Admin\Controllers;

use ZnSandbox\Sandbox\Synchronize\Domain\Interfaces\Services\SynchronizeServiceInterface;
use ZnSandbox\Sandbox\Synchronize\Yii2\Admin\Module;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnCore\Base\I18Next\Facades\I18Next;
use ZnLib\Web\Widgets\BreadcrumbWidget;
use ZnUser\Rbac\Domain\Enums\Rbac\ExtraPermissionEnum;
use ZnYii\Web\Controllers\BaseController;

class SynchronizeController extends BaseController
{

    protected $baseUri = '/tools/synchronize';
    private $toastrService;
    private $synchronizeService;

    public function __construct(
        string $id,
        Module $module,
        BreadcrumbWidget $breadcrumbWidget,
        ToastrServiceInterface $toastrService,
        SynchronizeServiceInterface $synchronizeService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->toastrService = $toastrService;
        $this->breadcrumbWidget = $breadcrumbWidget;
        $this->synchronizeService = $synchronizeService;
        $this->breadcrumbWidget->add(I18Next::t('synchronize', 'synchronize.title'), Url::to([$this->baseUri]));
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [ExtraPermissionEnum::ADMIN_ONLY],
                        'actions' => [
                            'index'
                        ],
                    ]
                ],
            ],
        ];
    }

    public function actions()
    {
        return [];
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {
            $this->synchronizeService->sync();
            $this->toastrService->success(['tools', 'synchronize.message.sync_success']);
        }
        $diffCollection = $this->synchronizeService->diff();
        return $this->render('index', [
            'diffCollection' => $diffCollection,
        ]);
    }
}
