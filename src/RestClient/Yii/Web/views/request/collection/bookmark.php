<?php

use yii\helpers\Html;
use PhpLab\Sandbox\RestClient\Domain\Helpers\Postman\PostmanHelper;
use PhpLab\Sandbox\RestClient\Yii\Web\helpers\CollectionHelper;

/**
 * @var \yii\web\View $this
 * @var string $activeTag
 * @var array $items
 * @var \PhpLab\Sandbox\RestClient\Domain\Entities\ProjectEntity $projectEntity
 */

$items = CollectionHelper::prependCollection($items);

?>
<div class="rest-request-collection">
    <ul id="collection-list" class="request-list">
        <?php foreach ($items as $group => $rows): ?>
            <li>
                <div class="request-list-group">
                    <?= Html::encode($group) ?>
                    <?= Html::tag('span', count($rows), ['class' => 'counter']) ?>
                </div>
                <ul>
                    <?php foreach ($rows as $tag => $row): ?>
	                    <?= $this->render('item', [
		                    'type' => 'collection',
		                    'row' => $row,
		                    'activeTag' => $activeTag,
                            'projectEntity' => $projectEntity,
	                    ]) ?>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
        <li>
            <div class="request-list-group">
                Tools
            </div>
            <div>
		        <?php if ($items): ?>
			        <?= Html::a('Export Postman v2.1 Collection', ['collection/export-postman', 'postmanVersion' => PostmanHelper::POSTMAN_VERSION], [
				        'class' => 'btn btn-block btn-default',
				        'title' => 'Export collection to file.'
			        ]) ?>
		        <?php endif; ?>
            </div>
        </li>
    </ul>
</div>