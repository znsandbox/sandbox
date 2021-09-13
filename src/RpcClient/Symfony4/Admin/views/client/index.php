<?php

/**
 * @var $this \ZnLib\Web\View\View
 * @var $formView FormView|AbstractType[]
 * @var $dataProvider DataProvider
 * @var $baseUri string
 * @var $rpcResponseEntity \ZnLib\Rpc\Domain\Entities\RpcResponseEntity
 * @var $rpcRequestEntity \ZnLib\Rpc\Domain\Entities\RpcRequestEntity
 * @var $favoriteEntity \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity | null
 * @var $collection \Illuminate\Support\Collection | \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity[]
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use ZnCore\Base\Helpers\StringHelper;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Libs\DataProvider;
use ZnLib\Web\Widgets\Format\Formatters\ActionFormatter;
use ZnLib\Web\Widgets\Format\Formatters\LinkFormatter;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\ApiKeyEntity;

$attributes = [
    [
        'label' => 'ID',
        'attributeName' => 'id',
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.value'),
//        'attributeName' => 'value',
        'value' => function (ApiKeyEntity $apiKeyEntity) {
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

        <?= $this->renderFile(__DIR__ . '/_transport.php', [
            'rpcResponseEntity' => $rpcResponseEntity,
            'rpcRequestEntity' => $rpcRequestEntity,
        ]) ?>

    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-header">
                Favorite
            </div>
            <div class="list-group list-group-flush">
                <?= $this->renderFile(__DIR__ . '/_collection.php', [
                    'baseUri' => $baseUri,
                    'favoriteEntity' => $favoriteEntity,
                    'collection' => $collection,
                ]) ?>
            </div>
        </div>
    </div>
</div>
