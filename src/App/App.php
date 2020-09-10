<?php

use common\locators\DomainLocator as AppLocator;
use yii2rails\domain\base\BaseDomainLocator;
use yubundle\common\project\common\locators\DomainLocator as PackageLocator;

class App
{

    /**
     * the domain container
     *
     * @var AppLocator | PackageLocator | BaseDomainLocator
     */
    public static $domain;

}
