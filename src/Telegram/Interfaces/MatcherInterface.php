<?php

namespace ZnSandbox\Telegram\Interfaces;

use App\Core\Entities\RequestEntity;

interface MatcherInterface
{

    public function isMatch(RequestEntity $requestEntity): bool;

}