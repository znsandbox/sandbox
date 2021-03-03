<?php

namespace ZnSandbox\Sandbox\Wsdl\Symfony\Wsdl\Controllers;

class TestController
{

    public function hello(string $name): array
    {
        return [
            'Hello, ' . $name,
            'WTF???',
        ];
    }

    public function method1(string $name): string
    {
        return 'method1, ' . $name;
    }
}
