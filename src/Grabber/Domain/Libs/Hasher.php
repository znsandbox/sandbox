<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Libs;

use ZnCrypt\Base\Domain\Enums\HashAlgoEnum;
use ZnCrypt\Base\Domain\Helpers\SafeBase64Helper;
use ZnCrypt\Pki\JsonDSig\Domain\Libs\C14n;

class Hasher
{

    public function hashArray(array $data, string $hashAlgo = HashAlgoEnum::SHA1)
    {
        $c14n = new C14n(['sort-string', 'json-unescaped-unicode']);
        $canonicalJson = $c14n->encode($data);
        $hashBinary = hash($hashAlgo, $canonicalJson, true);
        return base64_encode($hashBinary);
    }
}
