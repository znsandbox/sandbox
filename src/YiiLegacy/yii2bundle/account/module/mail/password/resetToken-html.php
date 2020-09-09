<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user yii2bundle\account\domain\v3\entities\IdentityEntity */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/restore-password/reset', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
	<p>Hello <?= Html::encode($user->username) ?>,</p>

	<p>Follow the link below to reset your password:</p>

	<p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
