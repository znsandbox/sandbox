<?php

namespace ZnSandbox\Sandbox\EgovData\Domain\Libs;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

class EgovDataClient
{

    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function request(string $uri, array $params = []): array
    {
        $client = $this->getClient();
        $options = $this->createOptions($params);
        $response = $client->get($uri, $options);

        return $this->extractBodyFromResponse($response);
    }

    private function createOptions(array $params = []): array
    {
        $options = [];

        $query['apiKey'] = $this->apiKey;
        $query['source'] = json_encode($params, JSON_UNESCAPED_UNICODE);

        //$query = http_build_query($query);
        //$query = urldecode($query);
        //dd($query);

        $options['query'] = $query;
        return $options;
    }

    private function extractBodyFromResponse(ResponseInterface $response): array
    {
        $response->getBody()->rewind();
        $content = $response->getBody()->getContents();
        return json_decode($content);
    }

    private function getClient(): GuzzleClient
    {
        $client = new GuzzleClient([
            "defaults" => [
//                "verify" => __DIR__ . "/../data/nca_rsa.pem",
                //'verify' => false,
            ],
            'base_uri' => 'http://data.egov.kz',
        ]);
        //$client->setDefaultOption('verify', false);
        return $client;
    }
}

// openssl x509 -inform DER -in nca_rsa.crt -out nca_rsa.pem -text
// curl --remote-name --time-cond cacert.pem https://curl.se/ca/cacert.pem
