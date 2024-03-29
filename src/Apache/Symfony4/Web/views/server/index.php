<?php

/**
 * @var $this \ZnLib\Web\View\View
 * @var $formView FormView|AbstractType[]
 * @var $dataProvider DataProvider
 * @var $collection \Illuminate\Support\Collection | \ZnSandbox\Sandbox\Apache\Domain\Entities\ServerEntity[]
 * @var $baseUri string
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Libs\DataProvider;
use ZnLib\Web\Widgets\Collection\CollectionWidget;
use ZnLib\Web\Widgets\Format\Formatters\ActionFormatter;
use ZnLib\Web\Widgets\Format\Formatters\LinkFormatter;

$attributes = [
    [
        'label' => 'ServerName',
        'attributeName' => 'ServerName',
        'format' => 'html',
        'value' => function (\ZnSandbox\Sandbox\Apache\Domain\Entities\ServerEntity $serverEntity) {
            return \ZnCore\Base\Legacy\Yii\Helpers\Html::a($serverEntity->getServerName(), 'http://' . $serverEntity->getServerName(), ['target' => '_blank']);
        },
    ],
    [
        'label' => 'DocumentRoot',
        'attributeName' => 'DocumentRoot',
    ],
    [
        'formatter' => [
            'class' => ActionFormatter::class,
            'actions' => [
                'view',
                'update',
                'delete',
            ],
            'baseUrl' => $baseUri,
        ],
    ],
];

?>

<div class="row">
    <div class="col-lg-12">
        <?= CollectionWidget::widget([
            'collection' => $collection,
            'attributes' => $attributes,
        ]) ?>
        <div class="float-left111">
            <a class="btn btn-primary" href="<?= Url::to([$baseUri . '/create']) ?>" role="button">
                <i class="fa fa-plus"></i>
                <?= I18Next::t('core', 'action.create') ?>
            </a>
        </div>
    </div>
</div>
