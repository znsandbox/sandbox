<?php

namespace ZnSandbox\Sandbox\UserNotify\Yii2\Admin\Controllers;

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Enums\Rbac\NotifyMyHistoryPermissionEnum;
use ZnSandbox\Sandbox\UserNotify\Domain\Filters\HistoryFilter;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\MyHistoryServiceInterface;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnLib\Web\Widgets\BreadcrumbWidget;
use ZnYii\Web\Controllers\BaseController;

class HistoryController extends BaseController
{

    protected $baseUri = '/notify/history';
//    protected $formClass = HistoryForm::class;
    protected $entityClass = NotifyEntity::class;
    protected $filterModel = HistoryFilter::class;
    private $toastrService;

    public function __construct(
        string $id,
        Module $module, array $config = [],
        BreadcrumbWidget $breadcrumbWidget,
        MyHistoryServiceInterface $service,
        ToastrServiceInterface $toastrService
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->toastrService = $toastrService;
        $this->breadcrumbWidget = $breadcrumbWidget;
        $this->breadcrumbWidget->add(I18Next::t('notify', 'history.list'), Url::to([$this->baseUri]));
    }

    public function actions()
    {
        $actions = parent::actions();
        //$actions['restore'] = $this->getRestoreActionConfig();
        return [
            'index' => $actions['index'],
            'view' => $actions['view'],
            'delete' => $actions['delete'],
        ];
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'restore' => ['POST'],
                    'clear-all' => ['POST'],
                    'read-all' => ['POST'],
                    'read-one' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [NotifyMyHistoryPermissionEnum::ALL],
                        'actions' => ['index'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [NotifyMyHistoryPermissionEnum::ONE],
                        'actions' => ['view'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [NotifyMyHistoryPermissionEnum::DELETE],
                        'actions' => ['delete'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [NotifyMyHistoryPermissionEnum::RESTORE],
                        'actions' => ['restore'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [NotifyMyHistoryPermissionEnum::CLEAR_ALL],
                        'actions' => ['clear-all'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [NotifyMyHistoryPermissionEnum::READ_ALL],
                        'actions' => ['read-all', 'read-one'],
                    ],
                ],
            ],
        ];
    }

    public function with()
    {
        return [

        ];
    }

    public function actionClearAll()
    {
        $this->service->clearMyMessages();
        $this->toastrService->success(['notify', 'history.message.clear_all_success']);
        return $this->redirect([$this->baseUri]);
    }

    public function actionReadAll()
    {
        $this->service->readAll();
        $this->toastrService->success(['notify', 'history.message.read_all_success']);
        return $this->redirect([$this->baseUri]);
    }

    public function actionReadOne(int $id)
    {
        $this->service->seenById($id);
        $this->toastrService->success(['notify', 'history.message.read_one_success']);
        return $this->redirect([$this->baseUri]);
    }
}
