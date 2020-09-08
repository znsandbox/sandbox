<?php

use yii\helpers\Html;
use yii\web\Response;
use ZnSandbox\Sandbox\RestClient\Yii\Web\Widgets\BodyWidget;

/**
 * @var \yii\web\View $this
 * @var \Psr\Http\Message\ResponseInterface $response
 */
?>

<ul class="nav nav-tabs">
    <li>
        <a href="#response-body" data-toggle="tab">
            Response Body
        </a>
    </li>
    <li>
        <a href="#response-headers" data-toggle="tab">
            Response Headers
            <?= Html::tag('span', count($response->getHeaders()), [
                'class' => 'counter' . (! count($response->getHeaders()) ? ' hidden' : '')
            ]) ?>
        </a>
    </li>
    <li class="pull-right">
        <div class="info">
            Duration:
            <span class="label label-default">
                <?= round($duration * 1000) ?> ms
            </span>
        </div>
    </li>
    <li class="pull-right">
        <div class="info">
            Status:
            <?php
            $class = 'label';
            if ($response->getStatusCode() < 300) {
                $class .= ' label-success';
            } elseif ($response->getStatusCode() < 400) {
                $class .= ' label-info';
            } elseif ($response->getStatusCode() < 500) {
                $class .= ' label-warning';
            } else {
                $class .= ' label-danger';
            }
            ?>
            <span class="<?= $class ?>">
                <?= Html::encode($response->getStatusCode()) ?>
                <?= isset(Response::$httpStatuses[$response->getStatusCode()]) ? Response::$httpStatuses[$response->getStatusCode()] : '' ?>
            </span>
        </div>
    </li>
</ul>

<div class="tab-content">

    <div id="response-body" class="tab-pane">
        <?= BodyWidget::widget([
            'response' => $response,
            'frame' => $frame,
            'formatters' => $this->context->module->formatters,
        ]); ?>
    </div>

    <div id="response-headers" class="tab-pane">
        <?= $this->render('headers', [
            'response' => $response,
        ]); ?>
    </div>

</div>
