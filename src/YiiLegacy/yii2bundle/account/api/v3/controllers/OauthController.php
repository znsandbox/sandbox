<?php

namespace yii2bundle\account\api\v3\controllers;

use Yii;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use yii2rails\domain\helpers\Helper;
use yii2rails\extension\store\StoreFile;
use yii2rails\extension\web\helpers\Behavior;
use yii2rails\extension\web\helpers\ClientHelper;
use yii2bundle\rest\domain\rest\Controller;
use yubundle\account\console\forms\PseudoLoginForm;
use yii2bundle\account\domain\v3\interfaces\services\AuthInterface;

/**
 * Class AuthController
 *
 * @package yii2bundle\account\api\v3\controllers
 * @property AuthInterface $service
 */
class OauthController extends Controller
{
	
	public $service = 'account.auth';
	
	/**
	 * @inheritdoc
	 */
	/*public function behaviors()
	{
		return [
			'cors' => Behavior::cors(),
			'authenticator' => Behavior::auth(['info']),
		];
	}*/
	
	/**
	 * @inheritdoc
	 */
	/*protected function verbs()
	{
		return [
			'login' => ['POST'],
			'info' => ['GET'],
		];
	}*/
	
	/**
	 * @inheritdoc
	 */
	/*public function actions()
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
	}*/
	
	public function actionRegister()
	{
		
		$store = new StoreFile(ROOT_DIR . '/rr.json');
		$all = $store->load();
		$all[] = \Yii::$app->request->queryParams;
		$store->save($all);
		return \Yii::$app->request->queryParams;
	}
	
}