<?php

/**
 * @var View
 * @var Request $request
 * @var NotifyEntity $entity
 */

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Enums\NotifyStatusEnum;
use yii\helpers\Url;
use yii\web\Request;
use yii\web\View;
use ZnYii\Base\Helpers\ActionHelper;

?>

<div class="info-box">
    <span class="info-box-icon bg-<?= $entity->getColor() ?>"><i class="<?= $entity->getIcon() ?>"></i></span>
    <div class="info-box-content">
        <span class="info-box-text">
            <span class="float-right">
                <small class="text-secondary">
                    <?= $entity->getCreatedAt() ?>
                </small>
                <br/>
                <span class="float-right">
                    <?php if ($entity->getStatusId() == NotifyStatusEnum::NEW): ?>
                        <a class="text-decoration-none text-success" data-method="post"
                           href="<?= Url::to(['/notify/history/read-one', 'id' => $entity->getId()]) ?>" title=""><i
                                    class="fas fa-check-double"></i></a>
                    <?php else: ?>
                        <?= ActionHelper::generateRestoreOrDeleteAction($entity, '/notify/history', ActionHelper::TYPE_LINK) ?>
                    <?php endif; ?>
                </span>
            </span>
            <span>
                <p>
                    <b>
                        <a class="text-decoration-none"
                           href="<?= Url::to(['/notify/history/view', 'id' => $entity->getId()]) ?>">
                            <?= $entity->getSubject() ?>
                        </a>
                    </b>
                </p>
                <?= $entity->getContent() ?>
            </span>
        </span>
    </div>
</div>
