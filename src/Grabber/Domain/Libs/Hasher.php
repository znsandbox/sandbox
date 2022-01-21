<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Libs;

use ZnCrypt\Base\Domain\Helpers\SafeBase64Helper;
use ZnCrypt\Pki\JsonDSig\Domain\Libs\C14n;

class Hasher
{

    public function hashArray(array $data)
    {
        $c14n = new C14n(['sort-string', 'json-unescaped-unicode']);
        $canonicalJson = $c14n->encode($data);
        $hashBinary = hash('sha1', $canonicalJson, true);
        return base64_encode($hashBinary);
    }
}
