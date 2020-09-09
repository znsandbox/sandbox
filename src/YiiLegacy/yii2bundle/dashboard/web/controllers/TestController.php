<?php

namespace yii2bundle\dashboard\web\controllers;

use yii\web\Controller;
use yii2rails\domain\data\Query;
use yii2bundle\notify\domain\entities\SmsEntity;

class TestController extends Controller
{
	
	public function actionIndex()
	{
		prr('test');
		return $this->render('index');
	}

}
