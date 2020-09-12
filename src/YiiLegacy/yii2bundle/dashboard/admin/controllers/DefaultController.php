<?php

namespace yii2bundle\dashboard\admin\controllers;

use Yii;
use yii\web\Controller;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;

class DefaultController extends Controller
{
	
	public function actionIndex()
	{
		$logs = [];
		/*foreach($this->module->log as $alias) {
			if(FileHelper::has(Yii::getAlias($alias))) {
				$logs[] = $alias;
			}
		}*/
		return $this->render('index', ['logs' => $logs]);
	}

}
