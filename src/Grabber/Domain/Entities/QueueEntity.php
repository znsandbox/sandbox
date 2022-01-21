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
use ZnSandbox\Sandbox\Grabber\Domain\Enums\QueueStatusEnum;
use ZnSandbox\Sandbox\Grabber\Domain\Enums\QueueTypeEnum;
use ZnSandbox\Sandbox\Grabber\Domain\Libs\Hasher;

class QueueEntity implements EntityIdInterface, ValidateEntityByMetadataInterface, UniqueInterface
{

    protected $id = null;

    protected $siteId = null;

    protected $hash = null;

    protected $path = null;

    protected $query = null;

    protected $content = null;

    protected $type = null;

    protected $statusId = QueueStatusEnum::WAIT_APPROVING;

    protected $createdAt = null;

    protected $updatedAt = null;

    protected $site = null;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
//        $metadata->addPropertyConstraint('id', new Assert\Positive());
        $metadata->addPropertyConstraint('siteId', new Assert\NotBlank());
        $metadata->addPropertyConstraint('siteId', new Assert\Positive());
//        $metadata->addPropertyConstraint('hash', new Assert\NotBlank());
        $metadata->addPropertyConstraint('path', new Assert\NotBlank());
//        $metadata->addPropertyConstraint('query', new Assert\NotBlank());
//        $metadata->addPropertyConstraint('content', new Assert\NotBlank());
        $metadata->addPropertyConstraint('type', new Assert\NotBlank());
        $metadata->addPropertyConstraint('type', new Enum([
            'class' => QueueTypeEnum::class,
        ]));
        
        $metadata->addPropertyConstraint('statusId', new Assert\NotBlank());
        $metadata->addPropertyConstraint('statusId', new Assert\Positive());
        $metadata->addPropertyConstraint('statusId', new Enum([
            'class' => QueueStatusEnum::class,
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

    public function setSiteId($value) : void
    {
        $this->siteId = $value;
    }

    public function getSiteId()
    {
        return $this->siteId;
    }

    public function setHash($value) : void
    {
        $this->hash = $value;
    }

    public function getHash()
    {
        $hasher = new Hasher();
        return $hasher->hashArray([
            'siteId' => $this->siteId,
            'path' => $this->path,
            'query' => $this->query,
        ]);
        /*$c14n = new C14n(['sort-string', 'json-unescaped-unicode']);
        $actual = $c14n->encode([
            'siteId' => $this->siteId,
            'path' => $this->path,
            'query' => $this->query,
        ]);
        $hashBinary = hash('sha1', $actual, true);
        $hashB64 = SafeBase64Helper::encode($hashBinary);
        return $hashB64;*/
        //dd($hashB64);

//        return $this->hash;
    }

    public function setPath($value) : void
    {
        $this->path = $value;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setQuery($value) : void
    {
        $this->query = $value;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setContent($value) : void
    {
        $this->content = $value;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setType($value) : void
    {
        $this->type = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setStatusId($value) : void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        if($this->statusId !== null) {
            return $this->statusId;
        }
        if($this->getContent()) {
            return QueueStatusEnum::ENABLED;
        }
        return QueueStatusEnum::WAIT_APPROVING;
//        return $this->statusId;
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

    public function getSite(): ?SiteEntity
    {
        return $this->site;
    }

    public function setSite(?SiteEntity $site): void
    {
        $this->site = $site;
    }
}
