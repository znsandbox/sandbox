<?php

/**
 * @var $formView FormView|AbstractType[]
 * @var $dataProvider DataProvider
 * @var $baseUri string
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use ZnCore\Base\Byte\Helpers\ByteSizeFormatHelper;
use ZnLib\Web\Helpers\Url;
use ZnCore\Base\I18Next\Facades\I18Next;
use ZnCore\Domain\DataProvider\Libs\DataProvider;
use ZnLib\Web\Widgets\Collection\CollectionWidget;
use ZnLib\Web\Widgets\Format\Formatters\ActionFormatter;
use ZnLib\Web\Widgets\Format\Formatters\LinkFormatter;
use ZnSandbox\Sandbox\Asset\Domain\Entities\FileEntity;

$attributes = [
    [
        'label' => 'ID',
        'attributeName' => 'id',
    ],
    [
        'label' => I18Next::t('storage', 'file.attribute.name'),
        'attributeName' => 'name',
        'sort' => true,
        'formatter' => [
            'class' => LinkFormatter::class,
            'uri' => $baseUri . '/view',
        ],
    ],
    [
        'label' => I18Next::t('storage', 'file.attribute.extension'),
        'attributeName' => 'extension',
    ],
    [
        'label' => I18Next::t('storage', 'file.attribute.size'),
        'attributeName' => 'size',
        'value' => function (FileEntity $entity) {
            return ByteSizeFormatHelper::sizeFormat($entity->getSize());
        },
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.created_at'),
        'attributeName' => 'created_at',
        'sort' => true,
    ],
    [
        'formatter' => [
            'class' => ActionFormatter::class,
            'actions' => [
                'update',
                'delete',
            ],
            'baseUrl' => $baseUri,
        ],
    ],


//    [
//        'label' => 'ID',
//        'attributeName' => 'id',
//    ],
//    [
//        'label' => I18Next::t('core', 'main.attribute.title'),
//        'attributeName' => 'name',
//        'sort' => true,
//        'formatter' => [
//            'class' => LinkFormatter::class,
//            'uri' => $baseUri . '/view',
//        ],
//    ],
//    /*[
//        'label' => I18Next::t('core', 'main.attribute.name'),
//        'attributeName' => 'name',
//    ],*/
//    [
//        'formatter' => [
//            'class' => ActionFormatter::class,
//            'actions' => [
//                'update',
//                'delete',
//            ],
//            'baseUrl' => $baseUri,
//        ],
//    ],
];

?>

<div class="row">
    <div class="col-lg-12">
        <?= CollectionWidget::widget([
            'dataProvider' => $dataProvider,
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
