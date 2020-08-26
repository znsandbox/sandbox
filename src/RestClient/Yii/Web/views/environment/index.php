<?php

use PhpLab\Core\Libs\I18Next\Facades\I18Next;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \Packages\User\Domain\Entities\EnvironmentEntity[] | \Illuminate\Support\Collection $environmentCollection
 * @var \Packages\User\Domain\Entities\ProjectEntity $projectEntity
 */

$this->title = I18Next::t('restclient', 'environment.list_title');

?>

<div class="col-lg-12">
    <h2>
        <?= $this->title ?>
    </h2>
</div>

<div class="col-lg-12">
    <?php if ($environmentCollection->count()) { ?>
        <ul class="list-group">
            <?php foreach ($environmentCollection as $environmentEntity) { ?>
                <li class="list-group-item list-group-item-action">
                    <div class="btn-group pull-right">
                        <a href="<?= Url::to(['/rest-client/environment/update', 'id' => $environmentEntity->getId()]) ?>"
                           class="btn btn-xs btn-info">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="<?= Url::to(['/rest-client/environment/delete', 'id' => $environmentEntity->getId()]) ?>"
                           class="btn btn-xs btn-danger"
                           data-method="post"
                           data-confirm="<?= I18Next::t('restclient', 'environment.messages.delete_confirm') ?>">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                    <a href="<?= Url::to(['/rest-client/environment/view', 'id' => $environmentEntity->getId()]) ?>">
                        <?= $environmentEntity->getTitle() ?>
                        <span class="text-muted">1234567</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p class="text-muted">Empty list</p>
    <?php } ?>

    <a href="<?= Url::to(['/rest-client/environment/create', 'projectId' => $projectEntity->getId()]) ?>"
       class="btn btn-success"><?= I18Next::t('core', 'action.create') ?></a>

</div>
