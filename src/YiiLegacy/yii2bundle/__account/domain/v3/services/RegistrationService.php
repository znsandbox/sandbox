<?php

namespace yii2bundle\account\domain\v3\services;

use App;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use yii2bundle\account\domain\v3\enums\AccountConfirmActionEnum;
use yii2rails\extension\common\exceptions\AlreadyExistsException;
use yii2bundle\account\domain\v3\forms\registration\PersonInfoForm;
use yii2bundle\account\domain\v3\interfaces\services\RegistrationInterface;
use yubundle\user\domain\v1\entities\PersonEntity;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use yii2rails\domain\helpers\ErrorCollection;
use yii2rails\domain\helpers\Helper;
use yii2rails\domain\services\base\BaseService;
use yii2rails\extension\common\exceptions\CreatedHttpExceptionException;
use ZnCore\Base\Enums\Measure\TimeEnum;
use yii2bundle\account\domain\v3\exceptions\ConfirmAlreadyExistsException;
use yii2bundle\account\domain\v3\exceptions\ConfirmIncorrectCodeException;

class RegistrationService extends BaseService implements RegistrationInterface {
	
	public $smsCodeExpire = TimeEnum::SECOND_PER_MINUTE * 30;

    public function requestCodeWithPersonInfo(PersonInfoForm $model) {
        $model->scenario = PersonInfoForm::SCENARIO_PERSON_INFO;
        $this->_requestCode($model);
    }

	public function requestCode(PersonInfoForm $model) {
		$model->scenario = PersonInfoForm::SCENARIO_REQUEST_CODE;
        $this->_requestCode($model);
    }

    private function _requestCode(PersonInfoForm $model) {
        if(!$model->validate()) {
            throw new UnprocessableEntityHttpException($model);
        }
        $this->checkExistsByPhoneAndLogin($model);
        try {
            App::$domain->account->confirm->send($model->phone, AccountConfirmActionEnum::REGISTRATION, $this->smsCodeExpire);
        } catch(ConfirmAlreadyExistsException $e) {
            throw new CreatedHttpExceptionException(I18Next::t('account', 'registration.user_already_exists_but_not_activation'));
        }
    }
	
	public function verifyCode(PersonInfoForm $model) {
		$model->scenario = PersonInfoForm::SCENARIO_VERIFY_CODE;
        if(!$model->validate()) {
            throw new UnprocessableEntityHttpException($model);
        }

		$this->checkExistsByPhoneAndLogin($model);

        try {
            App::$domain->account->confirm->verifyCode($model->phone, AccountConfirmActionEnum::REGISTRATION, $model->activation_code);
        } catch(NotFoundHttpException $e) {
	        throw new NotFoundHttpException(I18Next::t('account', 'registration.temp_user_not_found'), 0, $e);
        } catch(ConfirmIncorrectCodeException $e) {
            throw new ConfirmIncorrectCodeException(I18Next::t('account', 'registration.invalid_activation_code'), 0, $e);
        }
    }
	
	public function createAccountWeb(PersonInfoForm $model) {
		$model->scenario = PersonInfoForm::SCENARIO_CREATE_ACCOUNT;
        if(!$model->validate()) {
            throw new UnprocessableEntityHttpException($model);
        }

		$this->checkExistsByPhoneAndLogin($model);

        // check exists
        // verify
        // create account
        App::$domain->account->login->createWeb($model);
        App::$domain->account->confirm->delete($model->phone, AccountConfirmActionEnum::REGISTRATION);
    }
	
	private function checkExistsByPhoneAndLogin(PersonInfoForm $model) {
        $isExistsByPhone = App::$domain->account->contact->isExistsByData($model->phone, 'phone');
	    if($isExistsByPhone) {
		    $model->addError('phone', I18Next::t('account', 'registration.user_already_exists_and_activated'));
		    throw new UnprocessableEntityHttpException($model);
	    }
		if(App::$domain->account->login->isExistsByLogin($model->login)) {
			$model->addError('login', I18Next::t('account', 'registration.user_already_exists_and_activated'));
			throw new UnprocessableEntityHttpException($model);
		}
	}

}
