<?php

namespace ZnSandbox\Sandbox\Cert\Domain\Entities;

use ZnCore\Base\Helpers\StringHelper;

class InfoEntity
{

    private $person;
    private $signature;
    private $isAuthenticCertificate;
    private $isAuthenticSignature;

    /**
     * @return mixed
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param mixed $person
     */
    public function setPerson($person): void
    {
        $this->person = $person;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature($signature): void
    {
        $this->signature = $signature;
    }

    /**
     * @return mixed
     */
    public function getIsAuthenticCertificate()
    {
        return $this->isAuthenticCertificate;
    }

    /**
     * @param mixed $isAuthenticCertificate
     */
    public function setIsAuthenticCertificate($isAuthenticCertificate): void
    {
        $this->isAuthenticCertificate = $isAuthenticCertificate;
    }

    /**
     * @return mixed
     */
    public function getIsAuthenticSignature()
    {
        return $this->isAuthenticSignature;
    }

    /**
     * @param mixed $isAuthenticSignature
     */
    public function setIsAuthenticSignature($isAuthenticSignature): void
    {
        $this->isAuthenticSignature = $isAuthenticSignature;
    }

}
