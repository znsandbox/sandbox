<?php

namespace yii2rails\extension\session\repositories\base;

use Yii;
use yii\helpers\Inflector;
use yii2rails\domain\interfaces\repositories\RepositoryInterface;
use yii2rails\domain\repositories\BaseRepository;

abstract class BaseSessionRepository extends BaseRepository implements RepositoryInterface {
	
	public $isFlash = false;
	
	public function sessionKey() {
		$baseClassName = basename(self::class);
		return Inflector::camel2id($baseClassName);
	}
	
	protected function setCollection(Array $collection) {
		$sessionKey = $this->sessionKey();
		if($this->isFlash) {
			Yii::$app->session->setFlash($sessionKey, $collection);
		} else {
			Yii::$app->session->set($sessionKey, $collection);
		}
	}
	
	protected function getCollection() {
		$sessionKey = $this->sessionKey();
		if($this->isFlash) {
			$collection = Yii::$app->session->getFlash($sessionKey);
		} else {
			$collection = Yii::$app->session->get($sessionKey);
		}
		if(!is_array($collection)) {
			return [];
		}
		return $collection;
	}
	
}