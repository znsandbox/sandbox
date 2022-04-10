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

    /**
     * @return null
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param null $document
     */
    public function setDocument($document): void
    {
        $this->document = $document;
    }

    /**
     * @return null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param null $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return null
     */
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
