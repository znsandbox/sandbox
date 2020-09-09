<?php

namespace yii2bundle\account\domain\v3\services;

use common\enums\rbac\RoleEnum;
use yii\web\NotFoundHttpException;
use yii2bundle\account\domain\v3\forms\LoginForm;
use yii2rails\domain\data\Query;
use yii2bundle\account\domain\v3\interfaces\services\IdentityInterface;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use yii2rails\domain\helpers\ErrorCollection;
use yii2rails\domain\services\base\BaseActiveService;

/**
 * Class IdentityService
 * 
 * @package yii2bundle\account\domain\v3\services
 * 
 * @property-read \yii2bundle\account\domain\v3\Domain $domain
 * @property-read \yii2bundle\account\domain\v3\interfaces\repositories\IdentityInterface $repository
 */
class IdentityService extends BaseActiveService implements IdentityInterface {

    public function create($data)
    {
        $loginForm = new LoginForm;
        $loginForm->load($data, '');
        if( ! $loginForm->validate()) {
            throw new UnprocessableEntityHttpException($loginForm);
        }

        $query = new Query;
        $query->where('login', $loginForm->login);
        try {
            $this->one($query);
            throw new UnprocessableEntityHttpException([
                'login' => ['Already exists']
            ]);
        } catch (NotFoundHttpException $e) {

        }
        $identityEntity = parent::create($data);
        \App::$domain->account->security->make($identityEntity->id, $loginForm->password);
        \Yii::$app->authManager->assign(\Yii::$app->authManager->createRole(RoleEnum::USER), $identityEntity->id);
        return $identityEntity;
    }

    protected function prepareQuery(Query $query = null)
    {
        $query = Query::forge($query);
        $phone = $query->getWhere('phone');
        if($phone) {
            $query->removeWhere('phone');
            try {
	            $contactEntity = \App::$domain->account->contact->oneByData($phone, 'phone');
	            $query->andWhere(['id' => $contactEntity->identity_id]);
            } catch(NotFoundHttpException $e) {
	            $query->andWhere(['id' => null]);
            }
        }
        return $query;
    }

}
