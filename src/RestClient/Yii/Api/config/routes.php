<?php

use yii\rest\UrlRule;
$version = API_VERSION_STRING;

return [
    ["class" => UrlRule::class, "controller" => ["{$version}/rest-project" => "restclient/project"]],

    [
        "class" => UrlRule::class,
        "controller" => [
            "{$version}/rest-favorite" => "restclient/favorite",
            "{$version}/rest-history" => "restclient/history",
        ],
        "except" => [
            'index',
            'update',
            'create',
        ],
        "extraPatterns" => [
            "all-by-project/<projectId>" => "all-by-project",
        ],
        "tokens" => [
            '{id}' => '<id:[\\w\\d\\_\\-]*>',
        ]
    ],

    "POST {$version}/rest-history/add-to-favorite" => "restclient/history/add-to-favorite",

    ["class" => UrlRule::class, "controller" => ["{$version}/rest-access" => "restclient/access"]],
    ["class" => UrlRule::class, "controller" => ["{$version}/rest-authorization" => "restclient/authorization"]],
];
