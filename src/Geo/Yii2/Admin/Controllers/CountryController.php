<?php

namespace ZnSandbox\Sandbox\Geo\Yii2\Admin\Controllers;

use ZnSandbox\Sandbox\Geo\Domain\Entities\CountryEntity;
use ZnSandbox\Sandbox\Geo\Domain\Filters\CountryFilter;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Services\CountryServiceInterface;
use ZnSandbox\Sandbox\Geo\Yii2\Admin\Forms\CountryForm;
use ZnSandbox\Sandbox\Geo\Yii2\Admin\Module;
use yii\helpers\Url;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnLib\Web\Widgets\BreadcrumbWidget;
use ZnYii\Web\Controllers\BaseController;

class CountryController  extends BaseController
{
    protected $baseUri = '/geo/country';
    protected $formClass = CountryForm::class;
    protected $entityClass = CountryEntity::class;
    protected $filterModel = CountryFilter::class;

    public function __construct(
        string $id,
        Module $module,
        BreadcrumbWidget $breadcrumbWidget,
        CountryServiceInterface $countryService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $countryService;
        $this->breadcrumbWidget = $breadcrumbWidget;
        $this->breadcrumbWidget->add(I18Next::t('geo', 'country.title'), Url::to([$this->baseUri]));
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['restore'] = $this->getRestoreActionConfig();
        return $actions;
    }

}