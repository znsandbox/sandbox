<?php

namespace ZnSandbox\Sandbox\Dashboard\Yii2\Web\controllers;

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
