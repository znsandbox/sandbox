<?php

/**
 * @var $baseUri string
 * @var $favoriteEntity \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity | null
 * @var $collection \Illuminate\Support\Collection | \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity[]
 */

use ZnSandbox\Sandbox\RpcClient\Domain\Entities\ApiKeyEntity;

$map = [];
foreach ($collection as $favoriteEntityItem) {
    $methodItems = explode('.', $favoriteEntityItem->getMethod());
    if(count($methodItems) > 1) {
        $groupName = $methodItems[0];
    } else {
        $groupName = 'other';
    }
    $map[$groupName][] = $favoriteEntityItem;
}
ksort($map);

?>

<?php foreach ($map as $groupName => $favoriteEntityItems): ?>
<?php sort($favoriteEntityItems); ?>
<h5 class="mt-3"><?= $groupName ?></h5>

<div class="list-group">

    <?php foreach ($favoriteEntityItems as $favoriteEntityItem): ?>
        <a href="<?= \ZnCore\Base\Legacy\Yii\Helpers\Url::to([$baseUri, 'id' => $favoriteEntityItem->getId()]) ?>"
           style="border: 1px solid rgba(0,0,0,.125) !important; padding: 0.3rem 0.7rem;"
           class="list-group-item list-group-item-action <?= $favoriteEntity && ($favoriteEntity->getId() == $favoriteEntityItem->getId()) ? 'active' : '' ?>">
            <div class="d-flex w-100 justify-content-between">
                <small><?= $favoriteEntityItem->getMethod() ?></small>
                <small class="text-muted111">
                    <?php if ($favoriteEntityItem->getAuthBy()): ?>
                        <?= $favoriteEntityItem->getAuth()->getLogin() ?> &nbsp;<i class="fas fa-user"></i>
                    <?php endif; ?>
                </small>
            </div>
            <?php if ($favoriteEntityItem->getDescription()): ?>
                <small class="text-muted111">
                    <?= $favoriteEntityItem->getDescription() ?>
                </small>
            <?php endif; ?>
        </a>
    <?php endforeach; ?>

</div>

<?php endforeach; ?>

