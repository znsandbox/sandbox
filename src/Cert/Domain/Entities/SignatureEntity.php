<?php

namespace ZnSandbox\Sandbox\Cert\Domain\Entities;

use ZnCore\Base\Helpers\StringHelper;

class SignatureEntity
{

    private $digest;
    private $signature;
    private $certificate;

    public function getDigest()
    {
        return $this->digest;
    }

    public function setDigest($digest): void
    {
        $this->digest = $digest;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function setSignature($signature): void
    {
        $this->signature = $signature;
    }

    public function getCertificate()
    {
        return $this->certificate;
    }

    public function getCertificatePemFormat()
    {
        return
            "-----BEGIN CERTIFICATE-----\n"
            . StringHelper::removeAllSpace($this->certificate, " ")
            . "\n-----END CERTIFICATE-----";
    }

    public function setCertificate($certificate): void
    {
        $this->certificate = $certificate;
    }
}
