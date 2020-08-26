<?php

/**
 * @var \yii\web\View $this
 * @var \Psr\Http\Message\ResponseInterface $response
 */

use yii\helpers\Html;

?>

<table class="table table-striped table-bordered">
    <!--<thead>
        <tr>
            <th>Name</th>
            <th>Value</th>
        </tr>
    </thead>-->
    <tbody>
    <?php
    foreach ($response->getHeaders() as $name => $values) {
        foreach ($values as $value) { ?>
            <tr>
                <th>
                    <?= Html::encode($name) ?>
                </th>
                <td>
                    <samp>
                        <?= Html::encode($value) ?>
                    </samp>
                </td>
            </tr>
        <?php }
    } ?>
    </tbody>
</table>