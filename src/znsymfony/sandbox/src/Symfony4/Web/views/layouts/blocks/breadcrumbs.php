<?php

use ZnCore\Base\Text\Helpers\Inflector;
use ZnLib\Web\Url\Helpers\Url;
use ZnLib\Web\TwBootstrap\Widgets\Breadcrumb\BreadcrumbWidget;

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
