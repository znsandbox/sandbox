<?php

/* @var $this yii\web\View
 * @var $logs array
 */

$this->title = Yii::t('dashboard/main', 'title');

?>

<div class="dashboard-index">
	
	<?php if($logs) { ?>
        <div class="alert alert-warning">
	        <?= Yii::t('dashboard/main', 'has_logs {link}', ['link' => 'logreader']) ?>
        </div>
	<?php } ?>
	<div class="jumbotron">
		<h1><?= Yii::t('dashboard/main', 'hello') ?></h1>

		<p class="lead"><?= Yii::t('dashboard/main', 'text') ?></p>
		
	</div>

</div>
