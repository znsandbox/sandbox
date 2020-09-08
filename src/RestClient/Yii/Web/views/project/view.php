<?php

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \ZnSandbox\Sandbox\RestClient\Domain\Entities\ProjectEntity $projectEntity
 * @var \ZnSandbox\Sandbox\RestClient\Domain\Entities\EnvironmentEntity[] | \Illuminate\Support\Collection $environmentCollection
 */

$this->title = $projectEntity->getTitle();

?>

<div class="col-lg-12">
    <div class="pull-right">
        <a href="<?= Url::to(['/rest-client/project/update', 'id' => $projectEntity->getId()]) ?>"
           class="btn btn-primary"><?= I18Next::t('core', 'action.update') ?></a>
    </div>
    <h2>
        <?= $this->title ?>
    </h2>
</div>

<div class="col-lg-12">
    <!--<div class="pull-right">
        <a href="<?/*= Url::to(['/rest-client/environment/index', 'project-id' => $projectEntity->getId()]) */?>" class="btn btn-default"><?/*= I18Next::t('restclient', 'identity.list_title') */?></a>
    </div>-->
    <h3>
        <?= I18Next::t('restclient', 'environment.list_title') ?>
    </h3>

    <?php if ($environmentCollection->count()) { ?>
        <ul class="list-group">
            <?php foreach ($environmentCollection as $environmentEntity) { ?>
                <li class="list-group-item list-group-item-action">
                    <div class="pull-right">

                        <div class="btn-group">
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
                    </div>
                    <?= $environmentEntity->getTitle() ?>
                    <small class="text-muted">(<?= $environmentEntity->getUrl() ?>)</small>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p class="text-muted">Empty list</p>
    <?php } ?>

    <a href="<?= Url::to(['/rest-client/environment/create', 'projectId' => $projectEntity->getId()]) ?>" class="btn btn-success"><?= I18Next::t('core', 'action.create') ?></a>

</div>
