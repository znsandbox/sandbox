<?php
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var string $activeTag
 * @var array $items
 * @var \ZnSandbox\Sandbox\RestClient\Domain\Entities\ProjectEntity $projectEntity
 */
?>
<div class="rest-request-history">
    <ul id="history-list" class="request-list">
        <?php foreach ($items as $row): ?>
	        <?= $this->render('item', [
		        'type' => 'history',
                //'tag' => $tag,
                'row' => $row,
		        'activeTag' => $activeTag,
                'projectEntity' => $projectEntity,
	        ]) ?>
        <?php endforeach; ?>
    </ul>

    <?php if ($items): ?>
        <div>
            <?= Html::a('Clear History', ['history/clear', 'projectName' => $projectEntity->getName()], [
                'data' => ['method' => 'post', 'confirm' => 'Are you sure?'],
                'class' => 'btn btn-block btn-danger',
                'title' => 'Full clear history.'
            ]) ?>
        </div>
    <?php endif; ?>
</div>