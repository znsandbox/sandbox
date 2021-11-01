<?php

namespace ZnSandbox\Sandbox\App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use ZnSandbox\Sandbox\App\Libs\CallAction;
use ZnSandbox\Sandbox\Error\Symfony4\Web\Controllers\ErrorController2;

class ErrorHandleSubscriber implements EventSubscriberInterface
{

    private $callAction;

    public function __construct(
        CallAction $callAction
    )
    {
        $this->callAction = $callAction;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
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

        $event->setResponse($response);
        $event->stopPropagation();
    }
}
