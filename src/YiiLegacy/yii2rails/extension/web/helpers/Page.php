<?php

namespace yii2rails\extension\web\helpers;

use Yii;
use yii\helpers\Url;
use yii2rails\extension\yii\helpers\FileHelper;
use yii2rails\extension\yii\helpers\Html;

class Page {
	
	static function beginDraw($attrs = []) {
		Yii::$app->view->beginPage() ?>
		<!DOCTYPE html>
		<html lang="<?= Yii::$app->language ?>">
		<head>
			<meta charset="<?= Yii::$app->charset ?>">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<?= Html::csrfMetaTags() ?>
			<title><?= Html::encode(Yii::$app->view->title) ?></title>
			<?php Yii::$app->view->head() ?>
		</head>
		<body <?= Html::renderTagAttributes($attrs) ?> >
        <span id="go_to_top"></span>
		<?php Yii::$app->view->beginBody();
	}
	
	static function endDraw() {
		Yii::$app->view->endBody() ?>
		</body>
		</html>
		<?php Yii::$app->view->endPage();
	}
	
	static function snippet($name, $from = null, $vars = []) {
		if(FileHelper::isAlias($name)) {
			$fileName = $name;
        } else {
			$from = !empty($from) ? $from : '@app';
			$fileName = $from . '/views/snippets/' . $name;
        }
        $fileName .= '.php';
		return Yii::$app->view->renderFile($fileName, $vars);
	}

	public static function favicon($icoName = null) {
		if(empty($icoName)) {
			return null;
		}
		$url = Url::to([SL . $icoName]);
		Yii::$app->view->registerLinkTag([
			'rel' => 'icon',
			'type' => FileHelper::getMimeTypeByExtension($icoName),
			'href' => $url,
		]);
    }
	
}
