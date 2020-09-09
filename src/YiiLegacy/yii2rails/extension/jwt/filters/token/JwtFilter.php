<?php

namespace yii2rails\extension\jwt\filters\token;

use yii\web\NotFoundHttpException;
use yii2rails\extension\yii\helpers\ArrayHelper;
use yii2bundle\account\domain\v3\entities\LoginEntity;
use yii2bundle\account\domain\v3\filters\token\BaseTokenFilter;

/**
 * Class JwtFilter
 *
 * @package yii2rails\extension\jwt\filters\token
 * @deprecated move to \yii2bundle\account\domain\v3\strategies\token
 */
class JwtFilter extends BaseTokenFilter {

	public $profile = 'default';
	
	public function authByToken($token) {
		try {
			$tokenEntity = \App::$domain->jwt->token->decode($token, $this->profile);
		} catch(\Exception $e) {
			throw new NotFoundHttpException('the_token_has_expired', 0, $e);
		}
		/** @var LoginEntity $loginEntity */
		$loginEntity = \App::$domain->account->login->oneById($tokenEntity->subject['id']);
		$internalToken = ArrayHelper::getValue($tokenEntity, 'subject.token');
		if(!$internalToken) {
			$internalToken = $token;
		}
		$loginEntity->token = $internalToken;
		return $loginEntity;
	}
	
	public function login($body, $ip) {
		$loginEntity = \App::$domain->account->auth->authentication($body['login'], $body['password'], $ip);
		$subject = [
			'id' => $loginEntity->id,
			'token' => $loginEntity->token,
			//'partner' => null,
		];
		$tokenEntity = \App::$domain->jwt->token->forgeBySubject($subject, $this->profile);
		$loginEntity->token = $this->forgeToken($tokenEntity->token);
		return $loginEntity;
	}

}
