<?php

namespace ZnSandbox\Sandbox\Cert\Domain\Entities;

use ZnCore\Base\Helpers\StringHelper;
use ZnCrypt\Pki\Domain\Helpers\RsaKeyHelper;

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

    public function getCertificatePemFormat() :string
    {
        $certificate = StringHelper::removeAllSpace($this->certificate);
        return RsaKeyHelper::base64ToPem($certificate, 'CERTIFICATE');
    }

    public function setCertificate(string $certificate): void
    {
        $this->certificate = $certificate;
    }
}
