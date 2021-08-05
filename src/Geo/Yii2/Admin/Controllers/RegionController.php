<?php

namespace ZnSandbox\Sandbox\Geo\Yii2\Admin\Controllers;

use ZnSandbox\Sandbox\Geo\Domain\Entities\RegionEntity;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Services\RegionServiceInterface;
use ZnSandbox\Sandbox\Geo\Yii2\Admin\Forms\RegionForm;
use ZnSandbox\Sandbox\Geo\Yii2\Admin\Module;
use yii\helpers\Url;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnLib\Web\Widgets\BreadcrumbWidget;
use ZnYii\Web\Controllers\BaseController;

class RegionController  extends BaseController
{
    protected $baseUri = '/geo/region';
    protected $formClass = RegionForm::class;
    protected $entityClass = RegionEntity::class;

    public function __construct(
        string $id,
        Module $module,
        BreadcrumbWidget $breadcrumbWidget,
        RegionServiceInterface $regionService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $regionService;
        $this->breadcrumbWidget = $breadcrumbWidget;
        $this->breadcrumbWidget->add(I18Next::t('geo', 'region.title'), Url::to([$this->baseUri]));
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['restore'] = $this->getRestoreActionConfig();
        return $actions;
    }

}