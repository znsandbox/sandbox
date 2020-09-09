<?php

namespace yii2bundle\dashboard\web\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
	
	public function actionIndex()
	{
        return $this->render('index', ['data' => '']);
	}

    public function actionTest()
    {
        return $this->render('test', ['data' => '']);
    }

}
