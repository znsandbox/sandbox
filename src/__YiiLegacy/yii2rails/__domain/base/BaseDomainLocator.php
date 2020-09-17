<?php

namespace yii2rails\domain\base;

use yii\base\InvalidConfigException;
use yii\base\UnknownPropertyException;
use yii2rails\domain\Domain;
use yii\di\ServiceLocator;

/**
 *
 * @property-read \yii2rails\app\domain\Domain $app
 * @property-read \yii2rails\extension\jwt\Domain $jwt
 * @property-read \yii2rails\extension\package\domain\Domain $package
 * @property-read \yii2rails\extension\changelog\Domain $changelog
 * @property-read \yii2bundle\geo\domain\Domain $geo
 * @property-read \yii2bundle\navigation\domain\Domain $navigation
 * @property-read \yii2bundle\notify\domain\Domain $notify
 * @property-read \yii2bundle\qr\domain\Domain $qr
 * @property-read \yii2bundle\rbac\domain\Domain $rbac
 * @property-read \yii2bundle\rest\domain\Domain $rest
 *
 * @property-read \yii2bundle\account\domain\v3\Domain $account
 * @property-read \yii2bundle\article\domain\Domain $article
 * @property-read \yii2bundle\encrypt\domain\Domain $encrypt
 * @property-read \yii2tool\guide\domain\Domain $guide
 * @property-read \yii2bundle\lang\domain\Domain $lang
 * @property-read \yii2bundle\i18n\domain\Domain $i18n
 * @property-read \yii2bundle\model\domain\Domain $model
 * @property-read \yii2tool\tool\domain\Domain $tool
 * @property-read \yii2tool\vendor\domain\Domain $vendor
 *
 * @method Domain get($id)
 *
 */
class BaseDomainLocator extends ServiceLocator {

    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (UnknownPropertyException $e) {
            $message =
                'Domain "' . $name . '" not defined! ' . PHP_EOL .
                'Guide - https://github.com/yii2rails/yii2-domain/blob/master/guide/ru/exception-domain-not-defined.md';
            throw new InvalidConfigException($message, 0, $e);
        }
    }

}