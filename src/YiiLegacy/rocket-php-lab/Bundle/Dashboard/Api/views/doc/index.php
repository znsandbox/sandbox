<?php

use yii\web\View;

/* @var $this View */
/* @var $versionList array */

?>

<ul>
    <?php foreach ($versionList as $version) { ?>
        <li>
            <a href="/api/v<?= $version ?>">
                API version <?= $version ?>
            </a>
        </li>
    <?php } ?>
</ul>
