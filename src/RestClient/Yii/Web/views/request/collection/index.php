<?php

use ZnCore\Domain\Helpers\EntityHelper;
use yii\helpers\Html;
use ZnSandbox\Sandbox\RestClient\Domain\Helpers\Postman\PostmanHelper;
use ZnSandbox\Sandbox\RestClient\Yii\Web\helpers\CollectionHelper;

/**
 * @var \yii\web\View $this
 * @var string $activeTag
 * @var array $items
 * @var \ZnSandbox\Sandbox\RestClient\Domain\Entities\ProjectEntity $projectEntity
 */

?>

<ul class="request-lists nav nav-tabs">
    <li>
        <a href="#collection" data-toggle="tab">
            Collection
            <?php
            $count = array_reduce(EntityHelper::collectionToArray($collection), function ($sum, $rows) {
                return $sum + count($rows);
            }, 0);
            echo Html::tag('span', $count, [
                'class' => 'counter' . (!$count ? ' hidden' : '')
            ]);
            ?>
        </a>
    </li>
    <li>
        <a href="#history" data-toggle="tab">
            History
            <?= Html::tag('span', count($history), [
                'class' => 'counter' . (!count($history) ? ' hidden' : '')
            ]) ?>
        </a>
    </li>
</ul>

<div class="tab-content">

    <div class="form-group has-feedback">
        <input id="history-search" type="search" class="form-control" placeholder="Search" />
        <span class="glyphicon glyphicon-search form-control-feedback"></span>
    </div>

    <div id="collection" class="tab-pane">
        <?= $this->render('bookmark', [
            'activeTag' => $tag,
            'items' => $collection,
            'projectEntity' => $projectEntity,
        ]) ?>
    </div><!-- #collection -->

    <div id="history" class="tab-pane">
        <?= $this->render('history', [
            'activeTag' => $tag,
            'items' => $history,
            'projectEntity' => $projectEntity,
        ]) ?>
    </div><!-- #history -->

</div>
