<?php

namespace ZnSandbox\Telegram\Matchers;

use App\Core\Entities\RequestEntity;
use ZnSandbox\Telegram\Interfaces\MatcherInterface;

class AnyMatcher implements MatcherInterface
{

    public function isMatch(RequestEntity $requestEntity): bool
    {
        return true;
    }

}