<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Entities;

class PublicEntity
{

    protected $publicKey = null;
    protected $publicHash = null;
    protected $address = null;

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function setPublicKey($publicKey): void
    {
        $this->publicKey = $publicKey;
    }

    public function getPublicHash()
    {
        return $this->publicHash;
    }

    public function setPublicHash($publicHash): void
    {
        $this->publicHash = $publicHash;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address): void
    {
        $this->address = $address;
    }

}
