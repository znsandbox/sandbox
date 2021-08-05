<?php

/**
 * @var View $this
 * @var Request $request
 * @var DataProvider $dataProvider
 * @var ValidateEntityByMetadataInterface $filterModel
 * @var int $country_id
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

$this->title = I18Next::t('geo', 'region.title');

$attributes = [
    [
        'label' => 'ID',
        'attributeName' => 'id',
    ],
    [
        'label' => I18Next::t('geo', 'region.attribute.name'),
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
                        'region_id' => 'id',
                    ],
                    'baseUrl' => '/geo/locality',
                ],
            ],
            'baseUrl' => '/geo/region',
        ],
    ],
];

?>

<div class="row">

    <div class="col-lg-12">

        <?= CollectionWidget::widget([
            'dataProvider' => $dataProvider,
            'attributes' => $attributes,
        ]) ?>

        <div class="float-left">
            <a class="btn btn-primary" href="<?= Url::to(['/geo/region/create']) ?>" role="button">
                <i class="fa fa-plus"></i>
                <?= I18Next::t('core', 'action.create') ?>
            </a>
        </div>

    </div>

</div>
