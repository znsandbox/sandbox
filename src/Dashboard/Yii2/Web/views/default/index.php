<?php

use ZnCore\Base\Libs\I18Next\Facades\I18Next;

/* @var $this yii\web\View */

$this->title = I18Next::t('dashboard', 'main.title');

$data = empty($data) ? EMP : $data;

?>

<div class="welcome-index">

	<div class="jumbotron">
		<h1><?= I18Next::t('dashboard', 'main.hello') ?></h1>

        <?= $data ?>

		<p class="lead"><?= I18Next::t('dashboard', 'main.text') ?></p>
	</div>

</div>
