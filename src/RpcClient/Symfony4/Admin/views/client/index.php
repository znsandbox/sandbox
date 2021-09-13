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
use ZnCore\Domain\Libs\DataProvider;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\ApiKeyEntity;

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
