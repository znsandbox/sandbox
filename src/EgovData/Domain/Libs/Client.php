<?php

namespace ZnSandbox\Sandbox\EgovData\Domain\Libs;

use GuzzleHttp\Client as GuzzleClient;

class Client
{

    public function request()
    {
        $client = $this->getClient();
    }

    private function getClient(): GuzzleClient
    {
        return new GuzzleClient([
            'base_uri' => 'https://data.egov.kz/api',
        ]);
    }
}
