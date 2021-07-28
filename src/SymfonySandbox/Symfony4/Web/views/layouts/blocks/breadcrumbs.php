<?php

use ZnCore\Base\Legacy\Yii\Helpers\Inflector;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnLib\Web\Widgets\BreadcrumbWidget;

$currentUri = Url::getBaseUrl();
$uri = trim($currentUri, '/');

if($uri) {
    $uriArr = explode('/', $uri);
    $bc = new BreadcrumbWidget;
    $bc->add('<i class="fa fa-home"></i>', '/');
    $uriString = '';
    foreach ($uriArr as $uriItem) {
        if($uriItem != 'index') {
            $uriString .= '/' . $uriItem;
            $label = Inflector::titleize($uriItem);
            $bc->add($label, $uriString);
        }
    }
    echo $bc->render();
}
