<?php

namespace ZnSandbox\Sandbox\Web\Symfony4\Twig;

use ZnLib\Web\Widgets\ModalWidget;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ModalExtension extends AbstractExtension
{

    public function getFunctions()
    {
        return [
            new TwigFunction('modal', [$this, 'modal'], ['is_safe' => ['html']]),
        ];
    }

    public function modal(string $tagId, string $header, string $body, string $footer)
    {
        $widgetInstance = new ModalWidget;
        $widgetInstance->tagId = $tagId;
        $widgetInstance->header = $header;
        $widgetInstance->body = $body;
        $widgetInstance->footer = $footer;
        return $widgetInstance->render();
    }

}
