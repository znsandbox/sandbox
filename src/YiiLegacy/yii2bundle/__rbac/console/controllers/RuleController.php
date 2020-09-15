<?php

namespace yii2bundle\rbac\console\controllers;

use Yii;
use yii2rails\extension\console\base\Controller;
use yii2rails\extension\console\helpers\input\Question;
use yii2rails\extension\console\helpers\Output;

class RuleController extends Controller
{
	
	/**
	 * Search and add RBAC rules
	 */
	public function actionAdd()
	{
		Question::confirm(null, 1);
		$collection = \App::$domain->rbac->rule->searchInAllApps();
		$rules = \App::$domain->rbac->rule->insertBatch($collection);
		if($rules) {
			Output::items($rules, "Added " . count($rules) . " rules");
		} else {
			Output::block("All rules exists!");
		}
	}

	
}
