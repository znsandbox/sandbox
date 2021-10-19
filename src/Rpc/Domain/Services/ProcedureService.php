<?php

namespace ZnSandbox\Sandbox\Rpc\Domain\Services;

use ZnSandbox\Sandbox\Rpc\Domain\Entities\MethodEntity;
use ZnSandbox\Sandbox\Rpc\Domain\Enums\RpcEventEnum;
use ZnSandbox\Sandbox\Rpc\Domain\Events\RpcRequestEvent;
use ZnSandbox\Sandbox\Rpc\Domain\Events\RpcResponseEvent;
use ZnSandbox\Sandbox\Rpc\Domain\Interfaces\Services\MethodServiceInterface;
use ZnSandbox\Sandbox\Rpc\Domain\Subscribers\ApplicationAuthenticationSubscriber;
use ZnSandbox\Sandbox\Rpc\Domain\Subscribers\CheckAccessSubscriber;
use ZnSandbox\Sandbox\Rpc\Domain\Subscribers\CryptoProviderSubscriber;
use ZnSandbox\Sandbox\Rpc\Domain\Subscribers\LanguageSubscriber;
use ZnSandbox\Sandbox\Rpc\Domain\Subscribers\LogSubscriber;
use ZnSandbox\Sandbox\Rpc\Domain\Subscribers\TimestampSubscriber;
use ZnSandbox\Sandbox\Rpc\Domain\Subscribers\UserAuthenticationSubscriber;
use Illuminate\Container\EntryNotFoundException;
use ZnBundle\User\Domain\Exceptions\UnauthorizedException;
use ZnCore\Base\Enums\Http\HttpStatusCodeEnum;
use ZnCore\Base\Exceptions\ForbiddenException;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Libs\Event\Traits\EventDispatcherTrait;
use ZnCore\Base\Libs\InstanceProvider;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Helpers\ValidationHelper;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Domain\Enums\HttpHeaderEnum;
use ZnLib\Rpc\Domain\Enums\RpcErrorCodeEnum;
use ZnLib\Rpc\Domain\Exceptions\InvalidRequestException;
use ZnLib\Rpc\Domain\Exceptions\SystemErrorException;
use ZnLib\Rpc\Domain\Helpers\RequestHelper;
use ZnLib\Rpc\Domain\Libs\ResponseFormatter;

class ProcedureService
{

    use EventDispatcherTrait;

    private $methodService;
    private $responseFormatter;
    private $instanceProvider;

    public function __construct(
        ResponseFormatter $responseFormatter,
        MethodServiceInterface $methodService,
        InstanceProvider $instanceProvider
    )
    {
        set_error_handler([$this, 'errorHandler']);
        $this->responseFormatter = $responseFormatter;
        $this->methodService = $methodService;
        $this->instanceProvider = $instanceProvider;
    }

    public function subscribes(): array
    {
        return [
            ApplicationAuthenticationSubscriber::class, // Аутентификация приложения
            UserAuthenticationSubscriber::class, // Аутентификация пользователя
            CheckAccessSubscriber::class, // Проверка прав доступа
            TimestampSubscriber::class, // Проверка метки времени запроса и подстановка метки времени ответа
            CryptoProviderSubscriber::class, // Проверка подписи запроса и подписание ответа
            LogSubscriber::class, // Логирование запроса и ответа
            LanguageSubscriber::class, // Обработка языка
        ];
    }

    public function callOneProcedure(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        try {
            RequestHelper::validateRequest($requestEntity);

            $version = $requestEntity->getMetaItem(HttpHeaderEnum::VERSION);
            if (empty($version)) {
                throw new InvalidRequestException('Empty method version');
            }

            $methodEntity = $this->methodService->oneByMethodName($requestEntity->getMethod(), $version);
            $this->triggerBefore($requestEntity, $methodEntity);
            $parameters = [
                RpcRequestEntity::class => $requestEntity
            ];
            $responseEntity = $this->instanceProvider->callMethod($methodEntity->getHandlerClass(), [], $methodEntity->getHandlerMethod(), $parameters);
        } catch (NotFoundException $e) {
            $responseEntity = $this->responseFormatter->forgeErrorResponse(HttpStatusCodeEnum::NOT_FOUND, $e->getMessage(), EntityHelper::toArray($e), $e);
        } catch (UnprocessibleEntityException $e) {
            $responseEntity = $this->handleUnprocessibleEntityException($e);
        } catch (\ZnCore\Base\Exceptions\UnauthorizedException | UnauthorizedException $e) {
            $message = $e->getMessage() ?: 'Unauthorized';
            $responseEntity = $this->responseFormatter->forgeErrorResponse(HttpStatusCodeEnum::UNAUTHORIZED, $message, EntityHelper::toArray($e), $e);
        } catch (ForbiddenException $e) {
            $responseEntity = $this->responseFormatter->forgeErrorResponse(HttpStatusCodeEnum::FORBIDDEN, $e->getMessage(), EntityHelper::toArray($e), $e);
        } catch (EntryNotFoundException $e) {
            $message = 'Server error. Bad inject dependencies in "' . $e->getMessage() . '"';
            $responseEntity = $this->responseFormatter->forgeErrorResponse(RpcErrorCodeEnum::SYSTEM_ERROR, $message, EntityHelper::toArray($e), $e);
        } catch (\Throwable $e) {
            $code = $e->getCode() ?: RpcErrorCodeEnum::APPLICATION_ERROR;
            $message = $e->getMessage() ?: 'Application error: ' . get_class($e);
            $responseEntity = $this->responseFormatter->forgeErrorResponse(intval($code), $message, null, $e);
        }
        $responseEntity->setId($requestEntity->getId());
        $this->triggerAfter($requestEntity, $responseEntity);
        return $responseEntity;
    }

    public function errorHandler($error_level, $error_message, $error_file, $error_line, $error_context)
    {
        $message = $error_message . ' in ' . $error_file . ':' . $error_line;
        throw new SystemErrorException($message);
    }

    private function triggerBefore(RpcRequestEntity $requestEntity, MethodEntity $methodEntity)
    {
        $requestEvent = new RpcRequestEvent($requestEntity, $methodEntity);
        $this->getEventDispatcher()->dispatch($requestEvent, RpcEventEnum::BEFORE_RUN_ACTION);
    }

    private function triggerAfter(RpcRequestEntity $requestEntity, RpcResponseEntity $responseEntity)
    {
        $responseEvent = new RpcResponseEvent($requestEntity, $responseEntity);
        $this->getEventDispatcher()->dispatch($responseEvent, RpcEventEnum::AFTER_RUN_ACTION);
    }

    private function handleUnprocessibleEntityException(UnprocessibleEntityException $e): RpcResponseEntity
    {
        $errorData = ValidationHelper::collectionToArray($e->getErrorCollection());
        return $this->responseFormatter->forgeErrorResponse(RpcErrorCodeEnum::SERVER_ERROR_INVALID_PARAMS, 'Parameter validation error', $errorData);
    }
}
