<?php

namespace ZnSandbox\Telegram\Matchers;

use ZnSandbox\Telegram\Helpers\MatchHelper;
use ZnSandbox\Telegram\Interfaces\MatcherInterface;

class IntegerMatcher implements MatcherInterface
{

    private $patterns;

    public function __construct(array $patterns)
    {
        $this->patterns = $patterns;
    }

    public function isMatch(array $update): bool
    {
        $message = $update['message']['message'];
        return is_int($message);
    }

}