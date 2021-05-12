<?php

/**
 * @var View
 * @var Request $request
 * @var NotifyEntity $entity
 */

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use yii\web\Request;
use yii\web\View;

$this->title = $entity->getSubject();

?>

<div class="row">

    <div class="col-lg-12">
        <?= $this->render('_item', [
            'entity' => $entity,
        ]) ?>
    </div>

</div>
