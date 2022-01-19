<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Entities;

use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use DateTime;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Domain\Constraints\Enum;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCrypt\Base\Domain\Helpers\SafeBase64Helper;
use ZnCrypt\Pki\JsonDSig\Domain\Libs\C14n;

class PageEntity implements EntityIdInterface, ValidateEntityByMetadataInterface, UniqueInterface
{

    protected $id = null;
    
    protected $siteId = null;
    
    protected $hash = null;

    protected $title = null;

    protected $uri = null;
    
    protected $query = null;

    protected $content = null;

    protected $statusId = StatusEnum::WAIT_APPROVING;

    protected $createdAt = null;

    protected $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
//        $metadata->addPropertyConstraint('id', new Assert\Positive());
        $metadata->addPropertyConstraint('siteId', new Assert\NotBlank());
//        $metadata->addPropertyConstraint('hash', new Assert\NotBlank());
        $metadata->addPropertyConstraint('uri', new Assert\NotBlank());
//        $metadata->addPropertyConstraint('content', new Assert\NotBlank());
        $metadata->addPropertyConstraint('statusId', new Assert\NotBlank());
        $metadata->addPropertyConstraint('statusId', new Assert\Positive());
        $metadata->addPropertyConstraint('statusId', new Enum([
            'class' => StatusEnum::class,
        ]));
        $metadata->addPropertyConstraint('createdAt', new Assert\NotBlank());
//        $metadata->addPropertyConstraint('updatedAt', new Assert\NotBlank());
    }

    public function unique() : array
    {
        return [
            ['hash']
        ];
    }

    public function setId($value) : void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSiteId()
    {
        return $this->siteId;
    }

    public function setSiteId($siteId): void
    {
        $this->siteId = $siteId;
    }

    public function getHash()
    {
        $c14n = new C14n(['sort-string', 'json-unescaped-unicode']);
        $actual = $c14n->encode([
            'siteId' => $this->siteId,
            'uri' => $this->uri,
            'query' => $this->query,
        ]);
        $hashBinary = hash('sha1', $actual, true);
        $hashB64 = SafeBase64Helper::encode($hashBinary);
        return $hashB64;
        //dd($hashB64);
        
//        return $this->hash;
    }

    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

    public function setUri($value) : void
    {
        $this->uri = $value;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query): void
    {
        $this->query = $query;
    }

    public function setTitle($value) : void
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setContent($value) : void
    {
        $this->content = $value;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setStatusId($value) : void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function setCreatedAt($value) : void
    {
        $this->createdAt = $value;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($value) : void
    {
        $this->updatedAt = $value;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


}

