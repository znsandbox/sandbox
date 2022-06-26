<?php

/**
 * @var array $menu
 * @var string $moduleId
 */

use ZnSymfony\Sandbox\Symfony4\Web\Helpers\UrlHelper;
use ZnCore\Base\Text\Helpers\Inflector;
use ZnLib\Web\Components\Url\Helpers\Url;

$currentUri = Url::getBaseUrl();

?>

<ul>
    <?php foreach ($menu as $controllerName => $actions) {
        $controllerTitle = Inflector::titleize($controllerName);
        ?>
        <li>
            <?php if (in_array('index', $actions)) {
                $uri = UrlHelper::generateUri($moduleId, $controllerName, 'index');
                $linkClass = $uri == $currentUri ? 'font-weight-bold' : '';
                ?>
                <a class="<?= $linkClass ?>" href="<?= $uri ?>">
                    <?= $controllerTitle ?>
                </a>
            <?php } else { ?>
                <?= $controllerTitle ?>
            <?php } ?>
            <ul>
                <?php foreach ($actions as $actionName) {
                    if ($actionName != 'index') {
                        $actionTitle = Inflector::titleize($actionName);
                        $uri = UrlHelper::generateUri($moduleId, $controllerName, $actionName);
                        $linkClass = $uri == $currentUri ? 'font-weight-bold' : '';
                        ?>
                        <li>
                            <a class="<?= $linkClass ?>" href="<?= $uri ?>">
                                <?= $actionTitle ?>
                            </a>
                        </li>
                        <?php
                    }
                } ?>
            </ul>
        </li>
    <?php } ?>
</ul>
