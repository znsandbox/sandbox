<?php

namespace yii2bundle\account\api\v3\controllers;

use ZnCore\Base\Enums\Http\HttpStatusCodeEnum;
use Yii;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use yii2rails\domain\helpers\Helper;
use ZnCore\Base\Enums\Http\HttpHeaderEnum;
use ZnSandbox\Sandbox\Yii2\Helpers\Behavior;
use yii2rails\extension\web\helpers\ClientHelper;
use yii2bundle\rest\domain\rest\Controller;
use yii2woop\common\domain\account\v2\forms\AuthPseudoForm;
use yii2bundle\account\domain\v3\forms\LoginForm;
use yii2bundle\account\domain\v3\interfaces\services\AuthInterface;

/**
 * Class AuthController
 *
 * @package yii2bundle\account\api\v3\controllers
 * @property AuthInterface $service
 */
class AuthController extends Controller
{
	
	public $service = 'account.auth';
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'cors' => Behavior::cors(),
			'authenticator' => Behavior::auth(['info']),
		];
	}
	
	/**
	 * @inheritdoc
	 */
	protected function verbs()
	{
		return [
			'login' => ['POST'],
			'info' => ['GET'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'info' => [
				'class' => 'yii2bundle\rest\domain\rest\UniAction',
				'service' => Yii::$app->user,
				'successStatusCode' => 200,
				'serviceMethod' => 'getIdentity',
			],
			'options' => [
				'class' => 'yii\rest\OptionsAction',
			],
		];
	}
	
	public function actionLogin()
	{
		$body = Yii::$app->request->getBodyParams();
		try {
			$model = new LoginForm;
            Helper::forgeForm($model);
			$entity = $this->service->authenticationFromApi($model);
			Yii::$app->response->headers->set(HttpHeaderEnum::AUTHORIZATION, $entity->token);
            Yii::$app->response->setStatusCode(HttpStatusCodeEnum::NO_CONTENT);
			//return $entity;
		} catch(UnprocessableEntityHttpException $e) {
			Yii::$app->response->setStatusCode(422);
            return $e->getErrors();
		}
	}

}