<?php

$version = API_VERSION_STRING;

return [

    ["class" => "yii2bundle\\rest\\domain\\rules\\UrlRule", "controller" => ["{$version}/rbac-map" => "rbac/map"]],
    ["class" => "yii2bundle\\rest\\domain\\rules\\UrlRule", "controller" => ["{$version}/rbac-role" => "rbac/role"]],
    ["class" => "yii2bundle\\rest\\domain\\rules\\UrlRule", "controller" => ["{$version}/rbac-permission" => "rbac/permission"]],
    ["class" => "yii2bundle\\rest\\domain\\rules\\UrlRule", "controller" => ["{$version}/rbac-assignment" => "rbac/assignment"]],

];
