<?php

/**
 * @var $formView FormView|AbstractType[]
 * @var $dataProvider DataProvider
 * @var $baseUri string
 */

use ZnSandbox\Sandbox\RpcClient\Domain\Entities\ApiKeyEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use ZnCore\Base\Helpers\StringHelper;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Libs\DataProvider;
use ZnLib\Web\Widgets\Collection\CollectionWidget;
use ZnLib\Web\Widgets\Format\Formatters\ActionFormatter;
use ZnLib\Web\Widgets\Format\Formatters\LinkFormatter;

$attributes = [
    [
        'label' => 'ID',
        'attributeName' => 'id',
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.value'),
//        'attributeName' => 'value',
        'value' => function(ApiKeyEntity $apiKeyEntity) {
            return StringHelper::mask($apiKeyEntity->getValue(), 3);
        },
        'formatter' => [
            'class' => LinkFormatter::class,
            'uri' => $baseUri . '/view',
        ],
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.applicationId'),
        'attributeName' => 'application.title',
        'sort' => true,
        'sortAttribute' => 'application_id',
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.created_at'),
        'attributeName' => 'createdAt',
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.expired_at'),
        'attributeName' => 'expiredAt',
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
];

?>


<div class="row">
    <div class="col-lg-9">
        <?= $this->renderFile(__DIR__ . '/form.php', [
            'formView' => $formView,
            'baseUri' => $baseUri,
        ]) ?>
    </div>
    <div class="col-lg-3">
        <ul class="list-group">
            <li class="list-group-item">An item</li>
            <li class="list-group-item">A second item</li>
            <li class="list-group-item">A third item</li>
            <li class="list-group-item">A fourth item</li>
            <li class="list-group-item">And a fifth one</li>
        </ul>
    </div>
</div>
