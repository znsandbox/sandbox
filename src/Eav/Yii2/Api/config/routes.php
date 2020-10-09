<?php

use yii\rest\UrlRule;
//$version = API_VERSION_STRING;

return [
    ["class" => UrlRule::class, "controller" => ["{$version}/eav-book" => "eav/book"]],
    "{$version}/eav-validate/<entityId>" => "eav/entity/validate",
    ["class" => UrlRule::class, "controller" => ["{$version}/eav-entity-field" => "eav/entity-field"]],
    ["class" => UrlRule::class, "controller" => ["{$version}/eav-enum" => "eav/enum"]],
    ["class" => UrlRule::class, "controller" => ["{$version}/eav-field" => "eav/field"]],
    ["class" => UrlRule::class, "controller" => ["{$version}/eav-rule" => "eav/rule"]],
    ["class" => UrlRule::class, "controller" => ["{$version}/eav-unit" => "eav/unit"]],
];
