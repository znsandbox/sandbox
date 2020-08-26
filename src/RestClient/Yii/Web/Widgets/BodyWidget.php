<?php

namespace PhpLab\Sandbox\RestClient\Yii\Web\Widgets;

use PhpLab\Core\Enums\Http\HttpHeaderEnum;
use PhpLab\Sandbox\RestClient\Yii\Web\formatters\RawFormatter;
use PhpLab\Sandbox\RestClient\Yii\Web\HighlightAsset;
use PhpLab\Test\Helpers\RestHelper;
use PhpLab\Rest\Helpers\RestResponseHelper;
use yii\base\Widget;
use yii\helpers\Html;

class BodyWidget extends Widget
{

    public $frame;
    public $response;
    public $formatters;

    public function run()
    {
        $html = '';
        if ($this->frame) {
            echo '<iframe src="' . $this->frame . '" width="100%" height="800" align="left"></iframe>';
        } else {
            $content = $this->response->getBody()->getContents();
            if ($content) {
                try {
                    $contentType = RestResponseHelper::extractHeaderValues($this->response, HttpHeaderEnum::CONTENT_TYPE)[0];
                    $formatter = $this->createFormatter($contentType);
                    $contentFormatted = $formatter->format($content);
                    $html = $this->renderCodeHtml($contentFormatted, $formatter->getName());
                    $this->registerHighlightAssets();
                } catch (Exception $exception) {
                    $html = $this->renderWarningHtml($content, $exception->getMessage());
                }
            } else {
                $html = $this->renderInfoHtml('Empty body');
            }
        }
        return $html;
    }

    private function createFormatter($contentType): RawFormatter
    {
        $formatterConfig = $this->getFormatterConfig($this->formatters, $contentType);
        $formatter = \Yii::createObject($formatterConfig);
        return $formatter;
    }

    private function registerHighlightAssets()
    {
        HighlightAsset::register($this->view);
        $this->view->registerJs('hljs.highlightBlock(document.getElementById("response-content"));');
        $this->view->registerCss('pre code.hljs {background: transparent}');
    }

    private function renderInfoHtml(string $content): string
    {
        return '<div class="alert alert-info">' . $content . '</div>';
    }

    private function renderWarningHtml(string $content, string $errorMessage): string
    {
        $warningHtml = Html::tag('div', '<strong>Warning!</strong> ' . $errorMessage, [
            'class' => 'alert alert-warning',
        ]);
        $html = $warningHtml . $this->renderCodeHtml($content, 'raw');
        return $html;
    }

    private function renderCodeHtml($contentFormatted, $type)
    {
        $contentHtml = '<small class="pull-right text-muted">' . $type . '</small>' . Html::encode($contentFormatted);
        $contentOptions = [
            'id' => 'response-content',
            'class' => $type,
        ];
        $codeHtml = Html::tag('code', $contentHtml, $contentOptions);
        return Html::tag('pre', $codeHtml);
    }

    private function getFormatterConfig(array $formatters, string $contentType)
    {
        foreach ($formatters as $mimeType => $config) {
            if (strpos($contentType, $mimeType) === 0) {
                return $config;
                break;
            }
        }
        return RawFormatter::class;
    }

}
