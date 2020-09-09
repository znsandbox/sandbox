<?php

namespace yii2bundle\dashboard\api\controllers;

use Yii;
use yii\rest\Controller;
use yii2bundle\rest\domain\helpers\MiscHelper;

class DefaultController extends Controller
{
	
	public function actionIndex() {
	    $data = [
		    'title' => Yii::t('dashboard/main', 'title'),
		    'header' => Yii::t('dashboard/main', 'hello'),
		    'text' => Yii::t('dashboard/main', 'text'),
	    ];
		$data['text'] .= PHP_EOL . 'Для просмотра документации API переидите по ссылке: ' . MiscHelper::forgeApiUrl('doc/html');
		return $data;
    }

}
