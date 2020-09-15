<?php

namespace yii2bundle\lang\domain\services;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii2rails\domain\data\Query;
use yii2rails\domain\interfaces\services\ReadInterface;
use yii2rails\domain\services\base\BaseActiveService;
use yii2bundle\lang\domain\entities\LanguageEntity;
use yii2bundle\lang\domain\interfaces\services\LanguageInterface;

/**
 * Class LanguageService
 *
 * @package yii2bundle\lang\domain\services
 *
 * @property \yii2bundle\lang\domain\interfaces\repositories\LanguageInterface $repository
 */
class LanguageService extends BaseActiveService implements LanguageInterface, ReadInterface {

    public $aliases = [
        'kk' => 'kz',
    ];

	public function initCurrent() {
		if(APP == CONSOLE) {
			return;
		}
        $entity = $this->getLanguageFromStore();
		if(empty($entity)) {
            $entity = $this->setLanguageFromClient();
        }
        if(empty($entity)) {
            $entity = $this->repository->oneMain();
        }
        $this->saveCurrent($entity);
	}
	
	/**
	 * @return LanguageEntity
	 * @throws NotFoundHttpException
	 */
	public function oneCurrent() {
		return $this->repository->oneCurrent();
	}
	
	public function saveCurrent($language) {
		return $this->repository->saveCurrent($language);
	}

    public function oneByCode(string $code, Query $query = null) {
        $query = new Query;
        $query->andWhere(['code' => $code]);
        return $this->one($query);
    }

	public function oneByLocale($locale) {
        $locale = ArrayHelper::getValue($this->aliases, $locale, $locale);
		return $this->repository->oneByLocale($locale);
	}

	private function getLanguageFromStore() {
        $languageFromStore = $this->domain->repositories->store->get();
        if (empty($languageFromStore)) {
            return null;
        }
        try {
            return $this->oneByLocale([$languageFromStore]);
        } catch(NotFoundHttpException $e) {
            return null;
        }
    }

    private function setLanguageFromClient() {
        $clientLanguages = Yii::$app->getRequest()->getAcceptableLanguages();
        try {
            return $this->oneByLocale($clientLanguages);
        } catch(NotFoundHttpException $e) {
            return null;
        }
    }

}
