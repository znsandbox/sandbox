<?php

namespace ZnSandbox\Sandbox\Error\Symfony4\Web\Controllers;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use ZnBundle\User\Domain\Exceptions\UnauthorizedException;
use ZnBundle\User\Symfony4\Web\Enums\WebUserEnum;
use ZnCore\Base\Exceptions\ForbiddenException;
use ZnCore\Base\Exceptions\InvalidConfigException;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Legacy\Yii\Helpers\VarDumper;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Web\Symfony4\MicroApp\BaseWebController;

class ErrorController extends BaseWebController
{

    protected $viewsDir = __DIR__ . '/../views/error';
    private $session;
    private $logger;

    public function __construct(SessionInterface $session, LoggerInterface $logger)
    {
        $this->session = $session;
        $this->logger = $logger;
    }

    public function handleError(Request $request, \Exception $exception): Response
    {
        //dd($request);
        //EntityHelper::toArray($request, true)
        //dd();
        $this->logger->error($exception->getMessage(), [
            'request' => VarDumper::dumpAsString($request)
        ]);
        if ($exception instanceof ForbiddenException) {
            return $this->forbidden($request, $exception);
        }
        if ($exception instanceof UnauthorizedException) {
            return $this->unauthorized($request, $exception);
        }
        if ($exception instanceof NotFoundException) {
            return $this->notFound($request, $exception);
        }
        if ($exception instanceof ResourceNotFoundException) {
            return $this->notFound($request, $exception);
        }
        if ($exception instanceof InvalidConfigException) {
            return $this->commonRender('Config error', $exception->getMessage(), $exception);
        }
        return $this->commonRender('Error!', $exception->getMessage(), $exception);
    }

    private function commonRender(string $title, string $message, \Throwable $exception): Response
    {
        $params = [
            'title' => $title,
            'message' => $message,
        ];
        if (EnvHelper::isDebug()) {
            $params['exception'] = $exception;
        }
        return $this->render('handle-error', $params);
    }

    private function notFound(Request $request, \Exception $exception): Response
    {
        return $this->commonRender('Not found', 'Page not exists!', $exception);
    }

    private function unauthorized(Request $request, \Exception $exception): Response
    {
        if($request->getRequestUri() == '/auth') {
            return $this->commonRender('Unauthorized', 'Unauthorized!', $exception);
        }
        $this->session->set(WebUserEnum::UNAUTHORIZED_URL_SESSION_KEY, $request->getRequestUri());
        return $this->redirect('/auth');
    }

    private function forbidden(Request $request, \Exception $exception): Response
    {
        return $this->commonRender('Forbidden', 'Access error', $exception);
    }
}
