<?php

namespace ZnSandbox\Sandbox\App\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ErrorControllerInterface
{

    public function handleError(Request $request, \Exception $exception): Response;
}
