<?php

namespace yii2bundle\account\domain\v3\helpers\test;

use Yii;
use yii\web\UnauthorizedHttpException;
use yii2tool\test\helpers\RestTestHelper;
use yii2tool\test\helpers\TestHelper;
use yii2rails\app\domain\helpers\EnvService;
use yii2rails\extension\enum\enums\TimeEnum;
use App;
use yii\web\NotFoundHttpException;
use yii2bundle\notify\domain\entities\SmsEntity;
use yii2bundle\notify\domain\entities\TestEntity;
use yii2bundle\notify\domain\enums\TypeEnum;
use yii2bundle\rest\domain\entities\RequestEntity;
use yii2bundle\rest\domain\entities\ResponseEntity;
use yii2bundle\rest\domain\helpers\RestHelper;
use yii2rails\app\domain\helpers\Config;
use yii2rails\app\domain\helpers\Env;
use yii2rails\extension\web\enums\HttpMethodEnum;
use yii2rails\extension\yii\helpers\FileHelper;
use yii2bundle\account\domain\v3\entities\LoginEntity;

class AuthTestHelper
{

    private static $tokenCollection = [];
    private static $identity = null;
    private static $identityStack = [];

    public static function authByAccountManager() {
        $access = TestHelper::getEnvLocalConfig('accountManager', [
            'login' => 'admin',
            'password' => 'Wwwqqq111',
        ]);
        AuthTestHelper::authByLogin($access['login'], $access['password']);
    }

    public static function authByToken($token) {
        $identity = new LoginEntity;
        $identity->token = $token;
        AuthTestHelper::login($identity);
    }

    public static function authByLogin($login, $password = 'Wwwqqq111') {
        if(isset(self::$tokenCollection[$login])) {
            self::login(self::$tokenCollection[$login]);
            return;
        }
        $requestEntity = new RequestEntity;
        $requestEntity->method = HttpMethodEnum::POST;
        $requestEntity->uri = 'v1/auth';
        $requestEntity->data = [
            'login' => $login,
            'password' => $password,
        ];
        $responseEntity = RestTestHelper::sendRequest($requestEntity);
        if($responseEntity->status_code != 200) {
            throw new UnauthorizedHttpException;
        }

        $loginEntity = new LoginEntity($responseEntity->data);
        self::login($loginEntity);
        self::$tokenCollection[$login] = $loginEntity;
    }

    public static function getIdentity() {
        return self::$identity;
    }

    public static function login(LoginEntity $loginEntity) {
        self::saveCurrentAuth();
        self::$identity = $loginEntity;
    }

    public static function logout() {
        self::saveCurrentAuth();
        self::$identity = null;
    }

    public static function loadPrevAuth() {
        self::$identity = array_pop(self::$identityStack);
    }

    private static function saveCurrentAuth() {
        array_push(self::$identityStack, self::$identity);
    }

}
