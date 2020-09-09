<?php

function d($value) {
    if(is_object($value)) {
        if($value instanceof \yii\base\Arrayable) {
            $value = $value->toArray();
        } /*else {
            $value = \yii\helpers\ArrayHelper::toArray($value);
        }*/
    }
    $value = print_r($value, true);
    $value = "<pre><code>{$value}</code></pre>";
    exit($value);
}
