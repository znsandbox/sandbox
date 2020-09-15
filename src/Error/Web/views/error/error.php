<?php

/* @var $this yii\web\View
 * @var $exception Exception
 * @var $name string
 * @var $message string */

$this->title = $name;

?>

<div class="error">

	<h1>
		<?= $name ?>
	</h1>

	<div class="alert alert-danger">
		<?= nl2br($message) ?>
	</div>

</div>
