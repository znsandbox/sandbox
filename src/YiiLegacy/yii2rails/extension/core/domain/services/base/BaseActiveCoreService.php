<?php

namespace yii2rails\extension\core\domain\services\base;

use yii2rails\extension\core\domain\repositories\base\BaseActiveCoreRepository;
use yii2rails\domain\services\base\BaseActiveService;
use yii2rails\extension\common\helpers\ClassHelper;

class BaseActiveCoreService extends BaseActiveService {
	
	public $point = EMP;
	/**
	 * @var BaseActiveCoreRepository
	 */
	private $coreRepository;
	
	/**
	 * @param null $name
	 *
	 * @return mixed
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\web\ServerErrorHttpException
	 */
	public function getRepository($name = null) {
		try {
			return parent::getRepository($name);
		} catch(\yii\base\UnknownPropertyException $e) {
		
		}
		
		if(!isset($this->coreRepository)) {
			$this->coreRepository = ClassHelper::createObject([
				'class' => BaseActiveCoreRepository::class,
				'domain' => $this->domain,
				'id' => $this->id,
				'point' => $this->point,
			]);
		}
		return $this->coreRepository;
	}
	
}