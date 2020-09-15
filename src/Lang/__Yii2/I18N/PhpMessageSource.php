<?php

namespace ZnSandbox\Sandbox\Lang\Yii2\I18N;

use yii\i18n\MessageSource;
use yii2bundle\lang\domain\behaviors\MissingTranslationBehavior;
use ZnSandbox\Sandbox\Lang\Enums\LanguageEnum;

class PhpMessageSource extends \yii\i18n\PhpMessageSource
{
 
	public $forceTranslation = true;
	public $sourceLanguage = LanguageEnum::SOURCE;

	public function behaviors()
    {
        return [
            'missingTranslation' => MissingTranslationBehavior::class,
        ];
    }

}
