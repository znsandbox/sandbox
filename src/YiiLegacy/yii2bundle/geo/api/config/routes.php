<?php

$version = API_VERSION_STRING;

return [
    ["class" => "yii\\rest\\UrlRule", "controller" => ["{$version}/city" => "geo/city"]],
    ["class" => "yii\\rest\\UrlRule", "controller" => ["{$version}/country" => "geo/country"]],
    ["class" => "yii\\rest\\UrlRule", "controller" => ["{$version}/currency" => "geo/currency"]],
    ["class" => "yii\\rest\\UrlRule", "controller" => ["{$version}/region" => "geo/region"]],
];
