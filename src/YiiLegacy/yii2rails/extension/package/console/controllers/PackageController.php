<?php

namespace yii2rails\extension\package\console\controllers;

use yii2rails\domain\data\Query;
use yii2rails\extension\console\helpers\Alert;
use yii2rails\extension\console\helpers\input\Enter;
use yii2rails\extension\console\helpers\Output;
use yii2rails\extension\console\base\Controller;
use yii2rails\extension\package\domain\entities\ConfigEntity;
use yii2rails\extension\package\helpers\ConfigHelper;
use yii2rails\extension\package\helpers\PackageHelper;

class PackageController extends Controller {
	
	public function init() {
		parent::init();
		Output::line();
	}
	
	public function actionAll() {
		$query = Query::forge();
		
		/** @var ConfigEntity $configEntity */
		//$configEntity = \App::$domain->package->config->oneById('yii2woop/yii2-service');
		//$configEntity->setKeywords(['hgfds']);
		//\App::$domain->package->config->update($configEntity);
		
		//prr($configEntity,1,1);
		
		//$query->with('group');
		//$query->with('config');
		//$query->with('git');
		//$query->andWhere(['id'=>'yii2rails/yii2-extension']);
		//$query->where([ 'name' => ['yii2-service']]);
		//$collection = \App::$domain->package->package->oneById('yii2woop/yii2-service', $query);
		//$collection = \App::$domain->package->package->one($query);
		
		//$collection = \App::$domain->package->group->all();
		
		//$query->andWhere(['id'=>['yii2woop/yii2-service']]);
		//$collection = \App::$domain->package->package->all($query);

		//$collection = \App::$domain->git->git->oneByDir($dir);
		
		//$collection = \App::$domain->package->config->oneByDir('C:\OpenServer\domains\yii\all');
		$collection = \App::$domain->package->package->all($query);
		prr($collection,1,1);
	}
	
	public function actionDownload() {
		$group = Enter::display('Vendor name');
		$package = Enter::display('Package name');
		PackageHelper::forge($group, $package);
		Alert::success('Package downloaded and installed!');
	}
	
	public function actionInstall() {
		$group = Enter::display('Vendor name');
		$package = Enter::display('Package name');
		ConfigHelper::addPackage($group, $package);
		Alert::success('Package installed!');
	}
	
}
