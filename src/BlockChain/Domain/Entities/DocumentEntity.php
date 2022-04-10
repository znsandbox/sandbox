<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;

class DocumentEntity
{

    protected $document = null;

    protected $message = null;

    protected $signature = null;
    
    protected $public = null;

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): void
    {
        $this->document = $document;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message): void
    {
        $this->message = $message;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function setSignature($signature): void
    {
        $this->signature = $signature;
    }

    public function getPublic(): ?PublicEntity
    {
        return $this->public;
    }

    public function setPublic(PublicEntity $public): void
    {
        $this->public = $public;
    }
}
