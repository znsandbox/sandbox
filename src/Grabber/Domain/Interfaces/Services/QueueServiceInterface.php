<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services;

interface QueueServiceInterface
{

    public function add(string $url);
}
