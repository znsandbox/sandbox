<?php

/**
 * @var $formView FormView|AbstractType[]
 * @var $dataProvider DataProvider
 * @var $baseUri string
 * @var $rpcResponseEntity \ZnLib\Rpc\Domain\Entities\RpcResponseEntity
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

        <?php if ($rpcResponseEntity): ?>
            <textarea id="form_certificateRequest" class="form-control" name="form[certificateRequest]" rows="20"
                      style="font-size: 12px; font-family:monospace;"><?php echo json_encode(\ZnCore\Domain\Helpers\EntityHelper::toArray($rpcResponseEntity, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></textarea>
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
                    <a href="<?= \ZnCore\Base\Legacy\Yii\Helpers\Url::to([$baseUri, 'id' => $favoriteEntity->getId()]) ?>" class="list-group-item list-group-item-action">
                        <small>
                            <?= $favoriteEntity->getMethod() ?>
                            <?php if($favoriteEntity->getDescription()): ?>
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
