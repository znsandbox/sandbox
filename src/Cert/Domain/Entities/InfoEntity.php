<?php

namespace ZnSandbox\Sandbox\Cert\Domain\Entities;

use ZnCore\Base\Helpers\StringHelper;

class InfoEntity
{

    private $person;
    private $certificate;
    private $signature;
    private $isAuthenticCertificate;
    private $isAuthenticSignature;

    public function getPerson(): PersonEntity
    {
        return $this->person;
    }

    public function setPerson(PersonEntity $person): void
    {
        $this->person = $person;
    }

    public function getSignature()
    {
        return $this->signature;
    }

<<<<<<< HEAD
    /**
     * @return mixed
     */
    public function getCertificate(): CertificateEntity
    {
        return $this->certificate;
    }

    /**
     * @param mixed $certificate
     */
    public function setCertificate(CertificateEntity $certificate): void
    {
        $this->certificate = $certificate;
    }

    /**
     * @param mixed $signature
     */
=======
>>>>>>> bcec46f55915d118e0c87c8baed7825d203eb578
    public function setSignature($signature): void
    {
        $this->signature = $signature;
    }

    public function getIsAuthenticCertificate(): bool
    {
        return $this->isAuthenticCertificate;
    }

    public function setIsAuthenticCertificate(bool $isAuthenticCertificate): void
    {
        $this->isAuthenticCertificate = $isAuthenticCertificate;
    }

    public function getIsAuthenticSignature(): bool
    {
        return $this->isAuthenticSignature;
    }

    public function setIsAuthenticSignature(bool $isAuthenticSignature): void
    {
        $this->isAuthenticSignature = $isAuthenticSignature;
    }

}
