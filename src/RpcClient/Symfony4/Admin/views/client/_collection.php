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
                <?php
                $lifeTime = time() - $favoriteEntityItem->getCreatedAt()->getTimestamp();
                $isNew = $lifeTime < \ZnCore\Base\Enums\Measure\TimeEnum::SECOND_PER_DAY;
                $colorNew = '#007bff';
                if($lifeTime < \ZnCore\Base\Enums\Measure\TimeEnum::SECOND_PER_HOUR * 8 * 1) {
                    $colorNew = '#007bff';
                } elseif($lifeTime < \ZnCore\Base\Enums\Measure\TimeEnum::SECOND_PER_HOUR * 8 * 2) {
                    $colorNew = 'rgba(0,123,255,0.66)';
                } elseif($lifeTime < \ZnCore\Base\Enums\Measure\TimeEnum::SECOND_PER_HOUR * 8 * 3) {
                    $colorNew = 'rgba(0,123,255,0.45)';
                }


                ?>
                <small>
                    <?= $favoriteEntityItem->getMethod() ?>
                    <?php if ($isNew): ?>
                        <span class="badge badge-primary align-middle" style="background-color:  <?= $colorNew ?>;">New</span>
                    <?php endif; ?>

                </small>
                <small class="text-muted111">

                    <?php if ($favoriteEntityItem->getBody()): ?>
                        <i class="fas fa-circle align-middle" style="font-size: 5px; color: Dodgerblue;"></i>
                    <?php endif; ?>
                    <?php if ($favoriteEntityItem->getMeta()): ?>
                        <i class="fas fa-circle align-middle" style="font-size: 5px; color: Mediumslateblue;"></i>
                    <?php endif; ?>

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

