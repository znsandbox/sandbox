<?php

namespace yii2bundle\lang\domain\repositories\disc;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii2rails\domain\BaseEntity;
use yii2rails\domain\data\Query;
use yii2rails\extension\arrayTools\repositories\base\BaseActiveDiscRepository;
use yii2bundle\lang\domain\entities\LanguageEntity;
use yii2bundle\lang\domain\enums\LanguageEnum;
use yii2bundle\lang\domain\interfaces\repositories\LanguageInterface;

class LanguageRepository extends BaseActiveDiscRepository implements LanguageInterface {
	
	public $table = 'languages';
	public $path = '@yii2bundle/lang/domain/data';
	public $callback;
	
	protected $primaryKey = 'locale';
	
	/**
	 * @return LanguageEntity
	 * @throws NotFoundHttpException
	 */
	public function oneCurrent() {
		$entity = $this->oneByLocale(Yii::$app->language);
		return $entity;
	}
	
	public function saveCurrent($language) {
		if(!($language instanceof BaseEntity)) {
			try {
				$language = $this->oneByLocale($language);
			} catch(NotFoundHttpException $e) {
				return;
			}
		}
		Yii::$app->language = $language->code;
		$this->domain->repositories->store->set($language->locale);
		if (is_callable($this->callback)) {
			call_user_func($this->callback);
		}
	}
	
	public function oneMain() {
		$query = Query::forge();
		$query->where('is_main', true);
		return $this->one($query);
	}
	
	/**
	 * @param Query|null $query
	 *
	 * @return LanguageEntity[]
	 */
	public function all(Query $query = null) {
		$query = Query::forge($query);
		$collection = parent::all($query);
		if(YII_ENV_TEST) {
			$collection[] = $this->forgeEntity([
				'title' => 'Source',
				'name' => 'source',
				'code' => LanguageEnum::code(LanguageEnum::SOURCE),
				'locale' => LanguageEnum::SOURCE,
				'is_main' => false,
				'is_enabled' => true,
			]);
		}
		return $collection;
	}
	
	/**
	 * @return LanguageEntity
	 * @throws NotFoundHttpException
	 */
	public function oneByLocale($locales) {
		$collection = $this->all();
		$locales = ArrayHelper::toArray($locales);
		foreach ($locales as $language) {
			$pattern = preg_quote(substr($language, 0, 2), '/');
			/** @var LanguageEntity $entity */
			foreach ($collection as $entity) {
				if (preg_match('/^' . $pattern . '/', $entity->locale)) {
					return $entity;
				}
			}
		}
		return $this->oneMain();
	}
	
}
