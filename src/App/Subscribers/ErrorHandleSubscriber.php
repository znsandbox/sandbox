<?php

namespace ZnSandbox\Sandbox\App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use ZnLib\Web\View\View;
use ZnSandbox\Sandbox\App\Libs\CallAction;
use ZnSandbox\Sandbox\Error\Symfony4\Web\Controllers\ErrorController2;

class ErrorHandleSubscriber implements EventSubscriberInterface
{

    private $callAction;
    private $layout;
    private $layoutParams = [];
    private $view;

    public function __construct(
        CallAction $callAction,
        View $view
    )
    {
        $this->callAction = $callAction;
        $this->view = $view;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function getLayoutParams(): array
    {
        return $this->layoutParams;
    }

    public function setLayoutParams(array $layoutParams): void
    {
        $this->layoutParams = $layoutParams;
    }

    public function addLayoutParam(string $name, $value): void
    {
        $this->layoutParams[$name] = $value;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $request = $event->getRequest()->duplicate();
        $request->attributes->set('_controller', ErrorController2::class);
        $request->attributes->set('_action', 'handleError');

        $arguments = [
            $request,
            $event->getThrowable(),
        ];
        $response = $this->callAction->call($request, $arguments);
        $this->wrapContent($response);
        $event->setResponse($response);
        $event->stopPropagation();
    }

    private function wrapContent(Response $response): void
    {
        $params = $this->getLayoutParams();
        $params['content'] = $response->getContent();
//        $view = ContainerHelper::getContainer()->get(View::class);
        $content = $this->view->renderFile($this->layout, $params);
        $response->setContent($content);
    }
}
