<?php

namespace PhpLab\Sandbox\RestClient\Domain\Helpers\Postman;

use Yii;
use yii2rails\extension\web\enums\HttpMethodEnum;
use yii2bundle\rest\domain\entities\RequestEntity;
use yii2bundle\account\domain\v3\entities\TestEntity;

class InitHelper {

    public static function genCollection() {
        $items = [

            self::generateItem('init variables', '
                pm.globals.set("' . GeneratorHelper::genPureVariable('timezone') . '", "Asia/Almaty");
                pm.globals.set("' . GeneratorHelper::genPureVariable('language') . '", "ru");
                var host = pm.variables.get("' . GeneratorHelper::genPureVariable('host') . '");
                if(host == null || host == "") {
                    pm.globals.set("' . GeneratorHelper::genPureVariable('host') . '", "http://api.example.com/v1");
                }
            '),

            self::generateItem('set timezone Almaty', '
                pm.globals.set("' . GeneratorHelper::genPureVariable('timezone') . '", "Asia/Almaty");
            '),

            self::generateItem('set timezone UTC', '
                pm.globals.set("' . GeneratorHelper::genPureVariable('timezone') . '", "");
            '),

            self::generateItem('set language RU', '
                pm.globals.set("' . GeneratorHelper::genPureVariable('language') . '", "ru");
            '),

            self::generateItem('set language KZ', '
                pm.globals.set("' . GeneratorHelper::genPureVariable('language') . '", "kz");
            '),

            self::generateItem('remove token', '
                pm.globals.set("' . GeneratorHelper::genPureVariable('token') . '", "");
            '),

        ];
        return $items;
    }

    private static function generateItem(string $name, string $exec) {
        return [
            'name' => $name,
            'event' => [
                [
                    'listen' => 'test',
                    'script' => [
                        'id' => '2c924f5b-ab54-40e2-a821-23545d57583a',
                        'type' => 'text/javascript',
                        'exec' => [$exec],
                    ],
                ],
            ],
            'request' => [
                'method' => 'GET',
                'header' => [],
                'body' => [],
                'url' => [
                    'raw' => 'https://www.google.ru',
                    'host' => [
                        'https://www.google.ru',
                    ],
                    'path' => [],
                ],
                'description' => '',
            ],
            'response' => [],
        ];
    }

}