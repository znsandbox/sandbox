<?php

/**
 * @var array $menu
 * @var View $this
 * @var string $content
 */

use ZnSandbox\Sandbox\SymfonySandbox\Symfony4\Web\Helpers\ModuleHelper;
use ZnCore\Base\Legacy\Yii\Helpers\Inflector;
use ZnLib\Web\Symfony4\MicroApp\Assets\AppAsset;
use ZnLib\Web\Symfony4\MicroApp\Widgets\Layout\ScriptWidget;
use ZnLib\Web\Symfony4\MicroApp\Widgets\Layout\StyleWidget;
use ZnLib\Web\View\View;
use ZnLib\Web\Widgets\Toastr\ToastrWidget;

$moduleId = ModuleHelper::getCurrentModule();

(new AppAsset())->register($this);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?? '' ?></title>
    <?= StyleWidget::widget(['view' => $this]) ?>
    <link rel="stylesheet" href="/node_modules/code-prettify/loader/prettify.css" />
    <!--<link rel="stylesheet" href="/node_modules/code-prettify/loader/skins/desert.css" />-->
</head>
<body>

<?= $this->renderFile(__DIR__ . '/blocks/navbar.php') ?>

<div class="container mt-3">
    <div class="row">
        <div class="col-9">
            <?= $this->renderFile(__DIR__ . '/blocks/breadcrumbs.php') ?>
            <?= $content ?>
        </div>
        <div class="col-3">
            <?= $this->renderFile(__DIR__ . '/blocks/menu.php', [
                'moduleId' => $moduleId,
                'menu' => ModuleHelper::map('App\\' . Inflector::camelize($moduleId)),
            ]) ?>
        </div>
    </div>
</div>

<hr/>

<?= ToastrWidget::widget(['view' => $this]) ?>
<?= StyleWidget::widget(['view' => $this]) ?>
<?= ScriptWidget::widget(['view' => $this]) ?>

<div>
    <small class="text-muted">
        <?= round(microtime(true) - MICRO_TIME, 5) ?>
    </small>
</div>

</body>
</html>
