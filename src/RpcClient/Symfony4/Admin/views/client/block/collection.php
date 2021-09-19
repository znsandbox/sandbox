<?php

/**
 * @var $this \ZnLib\Web\View\View
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
        <?= $this->renderFile(__DIR__ . '/item.php', [
        'baseUri' => $baseUri,
        'favoriteEntity' => $favoriteEntity,
        'favoriteEntityItem' => $favoriteEntityItem,
    ]) ?>
    <?php endforeach; ?>
</div>
<?php endforeach; ?>
