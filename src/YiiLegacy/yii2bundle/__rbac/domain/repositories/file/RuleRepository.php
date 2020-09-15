<?php

namespace yii2bundle\rbac\domain\repositories\file;

use Yii;
use yii\web\UnprocessableEntityHttpException;
use yii2rails\domain\repositories\BaseRepository;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use yii2bundle\rbac\domain\helpers\RuleHelper;

class RuleRepository extends BaseRepository {

	public function searchByAppList($appList)
	{
		$allCollection = [];
		foreach ($appList as $app) {
			$collection = $this->searchByApp($app);
			if (!empty($collection)) {
				$allCollection = array_merge($allCollection, $collection);
			}
		}
		return $allCollection;
	}

	public function insertBatch($collection)
	{
		$result = [];
		foreach ($collection as $ruleEntity) {
			try {
				$this->insert($ruleEntity);
				$result[] = $ruleEntity->class;
			} catch(UnprocessableEntityHttpException $e) {}
		}
		return $result;
	}
	
	private function insert($ruleEntity)
	{
		if ($this->isExistsByClass($ruleEntity->class)) {
			throw new UnprocessableEntityHttpException;
		}
		$ruleInstance = new $ruleEntity->class;
		$isCreated = Yii::$app->authManager->add($ruleInstance);
		if (!$isCreated) {
			throw new UnprocessableEntityHttpException;
		}
	}

	private function searchByApp($app)
	{
		$options['only'][] = '*Rule.php';
		$fileList = FileHelper::findFiles($app, $options);
		$ruleList = RuleHelper::namespacesFromPathList($fileList);
		$collection = [];
		foreach($ruleList as $ruleClass) {
			$collection[] = $this->createEntity($ruleClass);
		}
		return $collection;
	}

	private function createEntity($ruleClass)
	{
		$ruleInstance = new $ruleClass;
		$data['class'] = $ruleClass;
		$data['name'] = !empty($ruleInstance->name) ? $ruleInstance->name : null;
		return $this->forgeEntity($data);
	}

	private function isExistsByClass($class)
	{
		$existsRules = Yii::$app->authManager->getRules();
		foreach ($existsRules as $rule) {
			if (is_object($rule) && get_class($rule) == $class) {
				return true;
			}
		}
		return false;
	}

}
