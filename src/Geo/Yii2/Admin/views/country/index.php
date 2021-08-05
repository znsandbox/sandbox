<?php

/**
 * @var View $this
 * @var Request $request
 * @var DataProvider $dataProvider
 * @var ValidateEntityByMetadataInterface $filterModel
 */

use yii\helpers\Url;
use yii\web\Request;
use yii\web\View;
use ZnBundle\Reference\Yii2\Admin\Formatters\Actions\ItemListAction;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Libs\DataProvider;
use ZnLib\Web\Widgets\Collection\CollectionWidget;
use ZnLib\Web\Widgets\Format\Formatters\ActionFormatter;

$this->title = I18Next::t('geo', 'country.title');

$attributes = [
    [
        'label' => 'ID',
        'attributeName' => 'id',
    ],
    [
        'label' => I18Next::t('geo', 'country.attribute.name'),
        'attributeName' => 'name'
    ],
    [
        'formatter' => [
            'class' => ActionFormatter::class,
            'actions' => [
                'itemList',
                'update',
                'delete',
            ],
            'actionDefinitions' => [
                'itemList' => [
                    'class' => ItemListAction::class,
                    'linkParams' => [
                        'country_id' => 'id',
                    ],
                    'baseUrl' => '/geo/region',
                ],
            ],
            'baseUrl' => '/geo/country',
        ],
    ],
];

?>

<div class="row">

    <div class="col-lg-12">

        <?= CollectionWidget::widget([
            'dataProvider' => $dataProvider,
            'attributes' => $attributes,
            'filter' => $filterModel,
        ]) ?>

        <div class="float-left">
            <a class="btn btn-primary" href="<?= Url::to(['/geo/country/create']) ?>" role="button">
                <i class="fa fa-plus"></i>
                <?= I18Next::t('core', 'action.create') ?>
            </a>
        </div>

    </div>

</div>
