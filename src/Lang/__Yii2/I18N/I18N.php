<?php

namespace ZnBundle\Language\Yii2\I18N;

use ZnBundle\Language\Yii2\Helpers\BundleHelper;
use ZnBundle\Language\Yii2\Helpers\LangHelper;

class I18N extends \yii\i18n\I18N
{
 
	public $translations = [];
	
	public function translate($category, $message, $params, $language) {
		$category = BundleHelper::register($category);
		return parent::translate($category, $message, $params, $language);
	}
 
	public function setAliases($aliases) {
		foreach($aliases as $name => $alias) {
			$translation = [
				'basePath' => $alias,
			];
			$this->translations[$name] = LangHelper::normalizeTranslation($translation);
		}
	}
	
}
