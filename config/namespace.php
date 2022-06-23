<?php

use Zn\Example\Plus;

$namespaces = [
    'Zn\\Example' => __DIR__ . '/../src/Example',
];

//dd(class_exists(\ZnCore\Base\Libs\Composer\Helpers\ComposerHelper::class));

foreach ($namespaces as $namespace => $path) {
    $path = realpath($path);
//    dd(\ZnCore\Base\Libs\FileSystem\Helpers\FileHelper::scanDir($path));
    //dd($namespace, $path);
    //\ZnCore\Base\Libs\Composer\Helpers\ComposerHelper::register($namespace, $path);
    //dd(Plus::run(1, 6));
}
