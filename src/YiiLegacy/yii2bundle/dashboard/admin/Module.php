<?php

namespace yii2bundle\dashboard\admin;
use yii2bundle\applicationTemplate\common\enums\ApplicationPermissionEnum;
use yii2rails\domain\helpers\DomainHelper;
use ZnSandbox\Sandbox\Yii2\Helpers\Behavior;

/**
 * Class Module
 * 
 * @package yii2bundle\dashboard\admin
 */
class Module extends \yii\base\Module {

	public $log;

    public function behaviors()
    {
        return [
            'access' => Behavior::access(ApplicationPermissionEnum::BACKEND_ALL),
        ];
    }
	
	public function init() {
		DomainHelper::forgeDomains([
			'dashboard' => 'yii2bundle\dashboard\domain\Domain',
		]);
		parent::init();
	}

}