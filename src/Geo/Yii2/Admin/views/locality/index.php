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
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Libs\DataProvider;
use ZnLib\Web\Widgets\Collection\CollectionWidget;
use ZnLib\Web\Widgets\Format\Formatters\ActionFormatter;
use ZnLib\Web\Widgets\Format\Formatters\Actions\DeleteAction;
use ZnLib\Web\Widgets\Format\Formatters\Actions\UpdateAction;


$this->title = I18Next::t('geo', 'locality.title');

$attributes = [
    [
        'label' => 'ID',
        'attributeName' => 'id',
    ],
    [
        'label' => I18Next::t('geo', 'locality.attribute.name'),
        'attributeName' => 'name'
    ],
    [
        'formatter' => [
            'class' => ActionFormatter::class,
            'actions' => [
                'update',
                'delete',
            ],
            'actionDefinitions' => [
                'update' => [
                    'class' => UpdateAction::class,
                    'linkParams' => [
                        'id' => 'id',
                        'region_id' => 'region_id',
                    ],
                    'baseUrl' => '/geo/locality',
                ],
                'delete' => [
                    'class' => DeleteAction::class,
                    'linkParams' => [
                        'id' => 'id',
                        'region_id' => 'region_id',
                    ],
                    'baseUrl' => '/geo/locality',
                ],
            ],
            'baseUrl' => '/geo/locality',
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
            <a class="btn btn-primary" href="<?= Url::to(['/geo/locality/create', 'region_id' => $request->get('region_id')]) ?>" role="button">
                <i class="fa fa-plus"></i>
                <?= I18Next::t('core', 'action.create') ?>
            </a>
        </div>

    </div>

</div>
