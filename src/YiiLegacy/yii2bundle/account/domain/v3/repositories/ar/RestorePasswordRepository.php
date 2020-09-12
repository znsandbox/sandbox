<?php

namespace yii2bundle\account\domain\v3\repositories\ar;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use Yii;
use yii2rails\domain\repositories\BaseRepository;
use ZnCore\Base\Enums\Measure\TimeEnum;
use yii2bundle\account\domain\v3\entities\LoginEntity;
use yii2bundle\account\domain\v3\entities\SecurityEntity;
use yii2bundle\account\domain\v3\helpers\LoginHelper;
use yii2bundle\account\domain\v3\interfaces\repositories\RestorePasswordInterface;

class RestorePasswordRepository extends BaseRepository implements RestorePasswordInterface {

	const CONFIRM_ACTION = 'restore-password';
	
	public $smsCodeExpire = TimeEnum::SECOND_PER_HOUR;
	
	public function requestNewPassword($login, $mail = null) {
		$login = LoginHelper::getPhone($login);
		$entity = \App::$domain->account->confirm->createNew($login, self::CONFIRM_ACTION, $this->smsCodeExpire);
		$message = I18Next::t('account', 'restore-password.restore_password_sms {activation_code}', ['activation_code' => $entity->activation_code]);
		\App::$domain->notify->sms->send($login, $message);
	}
	
	public function checkActivationCode($login, $code) {
		return \App::$domain->account->confirm->isVerifyCode($login, self::CONFIRM_ACTION, $code);
	}
	
	public function setNewPassword($login, $code, $password) {
		$login = LoginHelper::getPhone($login);
		\App::$domain->account->security->savePassword($login, $password);
		return \App::$domain->account->confirm->delete($login, self::CONFIRM_ACTION);
	}
	
}