<?php

/**
 * @var $this \ZnLib\Web\View\Libs\View
 * @var $formView FormView|AbstractType[]
 * @var $formRender \ZnLib\Web\Form\Libs\FormRender
 * @var $dataProvider DataProvider
 * @var $baseUri string
 * @var $rpcResponseEntity \ZnLib\Rpc\Domain\Entities\RpcResponseEntity
 * @var $rpcRequestEntity \ZnLib\Rpc\Domain\Entities\RpcRequestEntity
 * @var $favoriteEntity \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity | null
 * @var $favoriteCollection \Illuminate\Support\Collection | \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity[]
 * @var $historyCollection \Illuminate\Support\Collection | \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity[]
 * @var $methodCollectionIndexed \Illuminate\Support\Collection | \ZnLib\Rpc\Domain\Entities\MethodEntity[]
 * @var $routeMethodList array | string[]
 * @var $missingMethodList array | string[]
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use ZnLib\Web\Html\Helpers\Url;
use ZnCore\Domain\DataProvider\Libs\DataProvider;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\ApiKeyEntity;


/*$favCollection = [];
foreach ($methodCollectionIndexed as $methodEntity) {
//    if(in_array($methodEntity->getMethodName(), $missingMethodList) ) {
        $favEntity = new \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity();
        $favEntity->setMethod($methodEntity->getMethodName());
        $favEntity->setDescription($methodEntity->getTitle());
        if($methodEntity->getIsVerifyAuth()) {
            $favEntity->setAuthBy(1);
        }
        $favCollection[] = $favEntity;
//    }
}*/
$map = \ZnSandbox\Sandbox\RpcClient\Domain\Helpers\FavoriteHelper::generateFavoriteCollectionToMap($favCollection);

/**
 * @var $favoriteEntityItem \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity
 */

?>

<?= $formRender->errors() ?>

<?= $formRender->beginFrom() ?>

<h3>
    Missing method list
    <span class="badge badge-pill badge-secondary"><?= count($favCollection) ?></span>
</h3>

<?php foreach ($map as $groupName => $favoriteEntityItems): ?>
    <?php sort($favoriteEntityItems); ?>
    <h5 class="mt-3">
        <?= $groupName ?>
        <span class="badge badge-pill badge-secondary"><?= count($favoriteEntityItems) ?></span>
    </h5>
    <div class="list-group">
        <?php foreach ($favoriteEntityItems as $favoriteEntityItem): ?>
            <span href111="/rpc-client/request?id=9" class="list-group-item list-group-item-action " style="border: 1px solid rgba(0,0,0,.125) !important; padding: 0.3rem 0.7rem;">
                <div class="d-flex w-100 justify-content-between">
                    <small>
                        <?= $favoriteEntityItem->getMethod() ?>
                    </small>
                    <small class="text-muted111">
                        <?php if ($favoriteEntityItem->getBody()): ?>
                            <i class="fas fa-database align-middle" style="-color: Dodgerblue;" title="With body"></i>
                        <?php endif; ?>
                        <?php if ($favoriteEntityItem->getMeta()): ?>
                            <i class="fas fa-cog align-middle" style="-color: Mediumslateblue;" title="With meta"></i>
                        <?php endif; ?>

                        <?php if ($favoriteEntityItem->getAuthBy()): ?>
                            <i class="fas fa-user" title="Auth by"></i>
                        <?php endif; ?>
                    </small>
                </div>
                <small class="text-muted111">
                    <?= $favoriteEntityItem->getDescription() ?>
                </small>
            </span>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<div class="form-group">
    <?= $formRender->input('save', 'submit') ?>
</div>

<?= $formRender->endFrom() ?>
