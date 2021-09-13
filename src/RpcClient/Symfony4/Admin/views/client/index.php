<?php

/**
 * @var $formView FormView|AbstractType[]
 * @var $dataProvider DataProvider
 * @var $baseUri string
 * @var $rpcResponseEntity \ZnLib\Rpc\Domain\Entities\RpcResponseEntity
 * @var $rpcRequestEntity \ZnLib\Rpc\Domain\Entities\RpcRequestEntity
 * @var $collection \Illuminate\Support\Collection | \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity[]
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use ZnCore\Base\Helpers\StringHelper;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Libs\DataProvider;
use ZnLib\Rpc\Domain\Encoders\RequestEncoder;
use ZnLib\Rpc\Domain\Encoders\ResponseEncoder;
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

$responseEncoder = new ResponseEncoder();
$responseData = $responseEncoder->encode(EntityHelper::toArray($rpcResponseEntity, true));

$requestEncoder = new RequestEncoder();
$requestData = $requestEncoder->encode(EntityHelper::toArray($rpcRequestEntity, true));

$responseCode = json_encode($responseData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$requestCode = json_encode($requestData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>

<div class="row">
    <div class="col-lg-9">
        <?= $this->renderFile(__DIR__ . '/form.php', [
            'formView' => $formView,
            'baseUri' => $baseUri,
        ]) ?>

        <ul class="nav nav-tabs" id="result-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="result-response-tab" data-toggle="pill" href="#result-response"
                   role="tab" aria-controls="result-response" aria-selected="true">response</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="result-request-tab" data-toggle="pill" href="#result-request" role="tab"
                   aria-controls="result-request" aria-selected="false">request</a>
            </li>
        </ul>

        <?php if ($rpcRequestEntity): ?>
            <div class="tab-content" id="result-tabContent">
                <div class="tab-pane fade active show" id="result-response" role="tabpanel"
                     aria-labelledby="result-response-tab">
                    <?php if ($rpcResponseEntity): ?>
                        <small>
                            <pre><code><?= htmlspecialchars($responseCode) ?></code></pre>
                        </small>
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade" id="result-request" role="tabpanel" aria-labelledby="result-request-tab">
                    <?php if ($rpcRequestEntity): ?>
                        <small>
                            <pre><code><?= htmlspecialchars($requestCode) ?></code></pre>
                        </small>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
    <div class="col-lg-3">

        <div class="card">
            <div class="card-header">
                Favorite
            </div>

            <div class="list-group list-group-flush">
                <!--<a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                    The current link item
                </a>-->
                <?php foreach ($collection as $favoriteEntity): ?>
                    <a href="<?= \ZnCore\Base\Legacy\Yii\Helpers\Url::to([$baseUri, 'id' => $favoriteEntity->getId()]) ?>"
                       class="list-group-item list-group-item-action">
                        <small>
                            <?= $favoriteEntity->getMethod() ?>
                            <?php if ($favoriteEntity->getDescription()): ?>
                                <br/>
                                <?= $favoriteEntity->getDescription() ?>
                            <?php endif; ?>
                        </small>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>
