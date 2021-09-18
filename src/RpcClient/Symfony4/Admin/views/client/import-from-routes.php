<?php

/**
 * @var $this \ZnLib\Web\View\View
 * @var $formView FormView|AbstractType[]
 * @var $formRender \ZnLib\Web\Symfony4\MicroApp\Libs\FormRender
 * @var $dataProvider DataProvider
 * @var $baseUri string
 * @var $rpcResponseEntity \ZnLib\Rpc\Domain\Entities\RpcResponseEntity
 * @var $rpcRequestEntity \ZnLib\Rpc\Domain\Entities\RpcRequestEntity
 * @var $favoriteEntity \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity | null
 * @var $favoriteCollection \Illuminate\Support\Collection | \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity[]
 * @var $historyCollection \Illuminate\Support\Collection | \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity[]
 * @var $routeMethodList array | string[]
 * @var $missingMethodList array | string[]
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnCore\Domain\Libs\DataProvider;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\ApiKeyEntity;

?>

<?= $formRender->errors() ?>

<?= $formRender->beginFrom() ?>

<h3>Missing method list</h3>

 <?php if($missingMethodList): ?>
     <ul>
         <?php foreach ($missingMethodList as $methodName): ?>
             <li><?= $methodName ?></li>
         <?php endforeach; ?>
     </ul>
     <div class="form-group">
         <?= $formRender->input('save', 'submit') ?>
     </div>
 <?php else: ?>
     <div class="alert alert-secondary" role="alert">
         Method list is empty
     </div>
 <?php endif; ?>

<?= $formRender->endFrom() ?>
