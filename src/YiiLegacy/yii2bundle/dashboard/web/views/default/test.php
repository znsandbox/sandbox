<?php

/* @var $this yii\web\View */

$this->title = Yii::t('dashboard/main', 'title');

$data = empty($data) ? EMP : $data;

?>

<div class="welcome-index">

    <?= $data ?>

</div>
