<?php

namespace ZnSandbox\Sandbox\Rpc\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;

class MethodEntity implements ValidateEntityByMetadataInterface, UniqueInterface
{

    private $id = null;
    private $methodName = null;
    private $isVerifyEds = null;
    private $isVerifyAuth = null;
    private $permissionName = null;
    private $handlerClass = null;
    private $handlerMethod = null;
    private $version = null;
    private $statusId = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('method_name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('is_verify_eds', new Assert\NotBlank);
        $metadata->addPropertyConstraint('is_verify_auth', new Assert\NotBlank);
        $metadata->addPropertyConstraint('permission_name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('version_id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('status_id', new Assert\NotBlank);
    }

    public function unique() : array
    {
        return [
            ['method_name']
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getMethodName()
    {
        return $this->methodName;
    }

    public function setMethodName($methodName): void
    {
        $this->methodName = $methodName;
    }

    public function getIsVerifyEds()
    {
        return $this->isVerifyEds;
    }

    public function setIsVerifyEds($isVerifyEds): void
    {
        $this->isVerifyEds = $isVerifyEds;
    }

    public function getIsVerifyAuth()
    {
        return $this->isVerifyAuth;
    }

    public function setIsVerifyAuth($isVerifyAuth): void
    {
        $this->isVerifyAuth = $isVerifyAuth;
    }

    public function getPermissionName()
    {
        return $this->permissionName;
    }

    public function setPermissionName($permissionName): void
    {
        $this->permissionName = $permissionName;
    }

    public function getHandlerClass()
    {
        return $this->handlerClass;
    }

    public function setHandlerClass($handlerClass): void
    {
        $this->handlerClass = $handlerClass;
    }

    public function getHandlerMethod()
    {
        return $this->handlerMethod;
    }

    public function setHandlerMethod($handlerMethod): void
    {
        $this->handlerMethod = $handlerMethod;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version): void
    {
        $this->version = $version;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function setStatusId($statusId): void
    {
        $this->statusId = $statusId;
    }

}

