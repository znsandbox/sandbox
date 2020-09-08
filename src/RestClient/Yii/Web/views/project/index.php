<?php

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \ZnSandbox\Sandbox\RestClient\Domain\Entities\ProjectEntity[] | \Illuminate\Support\Collection $projectCollection
 */

$this->title = I18Next::t('restclient', 'project.list_title');

?>

<div class="col-lg-12">
    <!--<div class="pull-right">
        <a href="<?/*= Url::to(['/rest-client/identity/index']) */?>" class="btn btn-default"><?/*= I18Next::t('restclient', 'identity.list_title') */?></a>
    </div>-->
    <h2>
        <?= $this->title ?>
    </h2>
</div>

<div class="col-lg-12">
    <?php if($projectCollection->count()) { ?>
        <ul class="list-group">
            <?php foreach ($projectCollection as $projectEntity) { ?>
                <li class="list-group-item list-group-item-action">
                    <div class="btn-group pull-right">
                        <a href="<?= Url::to(['/rest-client/project/view', 'id' => $projectEntity->getId()]) ?>"
                           class="btn btn-xs btn-default">
                            <i class="fa fa-eye"></i>
                        </a>
                        <!--<a href="<?/*= Url::to(['/rest-client/environment/index', 'projectId' => $projectEntity->getId()]) */?>"
                           class="btn btn-xs btn-default">
                            <i class="fa fa-microchip"></i>
                        </a>-->
                        <a href="<?= Url::to(['/rest-client/project/update', 'id' => $projectEntity->getId()]) ?>"
                           class="btn btn-xs btn-info">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="<?= Url::to(['/rest-client/project/delete', 'id' => $projectEntity->getId()]) ?>"
                           class="btn btn-xs btn-danger"
                           data-method="post"
                           data-confirm="<?= I18Next::t('restclient', 'project.messages.delete_confirm') ?>">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                    <a href="<?= Url::to(['/rest-client/request/send', 'projectName' => $projectEntity->getName()]) ?>">
                        <?= $projectEntity->getTitle() ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p class="text-muted">Empty list</p>
    <?php } ?>

    <a href="<?= Url::to(['/rest-client/project/create']) ?>" class="btn btn-success"><?= I18Next::t('core', 'action.create') ?></a>

</div>
