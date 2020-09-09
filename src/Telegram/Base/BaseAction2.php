<?php

namespace ZnSandbox\Telegram\Base;

use App\Core\Entities\RequestEntity;
use App\Core\Services\ResponseService;
use ZnSandbox\Telegram\Services\SessionService;
use ZnSandbox\Telegram\Services\StateService;
use ZnSandbox\Telegram\Services\UserService;
use danog\MadelineProto\APIFactory;
use danog\MadelineProto\messages;
use Illuminate\Container\Container;
use ZnSandbox\Telegram\Entities\MessageEntity;

abstract class BaseAction2
{

    /** @var SessionService */
    protected $session;

    /** @var StateService */
    protected $state;

    /** @var ResponseService */
    protected $response;

    public function __construct()
    {
        $container = Container::getInstance();
        //$this->session = $container->get(SessionService::class);
        //$this->state = $container->get(StateService::class);
        /** @var ResponseService $response */
        $this->response = $container->get(ResponseService::class);
        //$this->response = new ResponseService($messages, $container->get(UserService::class));
    }

    public function stateName() {
        return null;
    }

    abstract public function run(RequestEntity $requestEntity);

}
