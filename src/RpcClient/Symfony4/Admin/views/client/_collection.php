<?php

/**
 * @var $baseUri string
 * @var $favoriteEntity \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity | null
 * @var $collection \Illuminate\Support\Collection | \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity[]
 */

use ZnSandbox\Sandbox\RpcClient\Domain\Entities\ApiKeyEntity;

?>

<?php foreach ($collection as $favoriteEntityItem): ?>
    <a href="<?= \ZnCore\Base\Legacy\Yii\Helpers\Url::to([$baseUri, 'id' => $favoriteEntityItem->getId()]) ?>"
       style="border: 1px solid rgba(0,0,0,.125) !important; padding: 0.3rem 0.7rem;"
       class="list-group-item list-group-item-action <?= $favoriteEntity && ($favoriteEntity->getId() == $favoriteEntityItem->getId()) ? 'active' : '' ?>">

        <div class="d-flex w-100 justify-content-between">
            <small class="mb-1"><?= $favoriteEntityItem->getMethod() ?></small>
            <small class="text-muted111">
                <?php if ($favoriteEntityItem->getAuthBy()): ?>
                    <i class="fas fa-key"></i>
                <?php endif; ?>
            </small>
        </div>
        <!--        <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>-->
        <?php if ($favoriteEntityItem->getDescription()): ?>
            <small class="text-muted111">
                <?= $favoriteEntityItem->getDescription() ?>
            </small>
        <?php endif; ?>
    </a>
<?php endforeach; ?>
