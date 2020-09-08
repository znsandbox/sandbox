<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var string        $activeTag
 * @var string        $tag
 * @var \ZnSandbox\Sandbox\RestClient\Domain\Entities\BookmarkEntity         $row
 * @var \ZnSandbox\Sandbox\RestClient\Domain\Entities\ProjectEntity $projectEntity
 */

$tag = $row->getHash();

$options = ['data-tag' => $tag];

if ($row->getStatus() < 300) {
	Html::addCssClass($options, 'success');
} elseif ($row->getStatus() < 400) {
	Html::addCssClass($options, 'info');
} elseif ($row->getStatus() < 500) {
	Html::addCssClass($options, 'warning');
} else {
	Html::addCssClass($options, 'danger');
}

if ($row->getMethod() == 'get' || $row->getMethod() == 'head' || $row->getMethod() == 'options') {
	$methodColor = '#63a8e2';
} elseif ($row->getMethod() == 'put' || $row->getMethod() == 'patch') {
	$methodColor = '#22bac4';
} elseif ($row->getMethod() == 'post') {
	$methodColor = '#6cbd7d';
} elseif ($row->getMethod() == 'delete') {
	$methodColor = '#d26460';
} else {
	$methodColor = '#fff';
}

if ($tag === $activeTag) {
	Html::addCssClass($options, 'active');
}
/*if(isset($row['description']request)) {
	try {
		$row->request = unserialize($row->request);
	} catch(\yii\base\ErrorException $e) {
		$row->request = [];
	}
}*/

?>
<li <?= Html::renderTagAttributes($options) ?>>
    <a href="<?= Url::to(['/rest-client/request/send', 'projectName' => $projectEntity->getName(), 'tag' => $tag]) ?>">
        <small class="request-name">
            
                        <span class="request-method label label-info" style="width: 100px !important; background-color: <?= $methodColor ?>;">
                            <?= Html::encode($row->getMethod()) ?>
	                        
	                        <?php if (!empty($row->getAuthorization())): ?>
                            &nbsp;
                            <span class="glyphicon glyphicon-lock" title="Authentication required"></span>
	                        <?php endif; ?>
                        </span>
                        <span class="request-endpoint">
                            &nbsp;
                            <?= Html::encode($row->getUri()) ?>
                        </span>
                    </small>
		<?php if (!empty($row->getDescription())): ?>
            <span class="request-description">
                            <?= Html::encode($row->getDescription()) ?>
                        </span>
		<?php endif; ?>
    </a>
    <div class="actions">
		<?php if ($row->getStatus() == \ZnSandbox\Sandbox\RestClient\Domain\Enums\StatusEnum::HISTORY): ?>
			<?= Html::a('&plus;', ['collection/link', 'tag' => $tag], [
				'data-method' => 'post',
				'title' => 'Move to collection.',
			]) ?>
		<?php endif; ?>
		<?= Html::a('&times;', [($type == 'history' ? 'history/delete' : 'collection/unlink'), 'tag' => $tag], [
			'data-method' => 'post',
			'title' => 'Remove from ' . $type . '.',
		]) ?>
    </div>
</li>