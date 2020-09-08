<?php

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \ZnBundle\User\Domain\Entities\IdentityEntity $identityEntity
 * @var \ZnSandbox\Sandbox\RestClient\Domain\Entities\ProjectEntity[] | \Illuminate\Support\Collection $projectCollection
 * @var \ZnSandbox\Sandbox\RestClient\Domain\Entities\ProjectEntity[] | \Illuminate\Support\Collection $hasProjectCollection
 */

$this->title = $identityEntity->getLogin();

?>

<div class="col-lg-12">
    <div class="pull-right">
        <a href="<?= Url::to(['/rest-client/identity/update', 'id' => $identityEntity->getId()]) ?>"
           class="btn btn-primary"><?= I18Next::t('core', 'action.update') ?></a>
    </div>
    <h2>
        <?= $this->title ?>
    </h2>
</div>

<div class="col-lg-6">
    <h3>
        <?= I18Next::t('restclient', 'project.not_has_list_title') ?>
    </h3>

    <?php if ($projectCollection->count()) { ?>
        <ul class="list-group">
            <?php foreach ($projectCollection as $projectEntity) { ?>
                <li class="list-group-item list-group-item-action">
                    <div class="btn-group pull-right">
                        <a href="<?= Url::to(['/rest-client/identity/attach', 'projectId' => $projectEntity->getId(), 'userId' => $identityEntity->getId()]) ?>"
                           class="btn btn-xs btn-info">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                    <?= $projectEntity->getTitle() ?>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p class="text-muted">Empty list</p>
    <?php } ?>
</div>

<div class="col-lg-6">
    <h3>
        <?= I18Next::t('restclient', 'project.has_list_title') ?>
    </h3>

    <?php if ($hasProjectCollection->count()) { ?>
        <ul class="list-group">
            <?php foreach ($hasProjectCollection as $projectEntity) { ?>
                <li class="list-group-item list-group-item-action">
                    <div class="btn-group pull-right">
                        <a href="<?= Url::to(['/rest-client/identity/detach', 'projectId' => $projectEntity->getId(), 'userId' => $identityEntity->getId()]) ?>"
                           class="btn btn-xs btn-danger"
                           data-method="post"
                           data-confirm="<?= I18Next::t('restclient', 'access.messages.delete_confirm') ?>">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                    <?= $projectEntity->getTitle() ?>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p class="text-muted">Empty list</p>
    <?php } ?>
</div>
