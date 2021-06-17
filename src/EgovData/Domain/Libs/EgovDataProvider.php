<?php

namespace ZnSandbox\Sandbox\EgovData\Domain\Libs;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;
use ZnCore\Domain\Libs\Query;

class EgovDataProvider
{

    private $client;
    private $apiVersion = 'v4';
    private $datasetName;
    private $datasetVersion;

    public function __construct(EgovDataClient $client, string $datasetName, string $datasetVersion)
    {
        $this->client = $client;
        $this->datasetName = $datasetName;
        $this->datasetVersion = $datasetVersion;
    }

    public function all(Query $query): Collection
    {
        $params = [];
        if($query->getParam(Query::PAGE)) {
            $params['from'] = $query->getParam(Query::PAGE);
        }
        if($query->getParam(Query::PER_PAGE)) {
            $params['size'] = $query->getParam(Query::PER_PAGE);
        }
        $data = $this->client->request('api/'.$this->apiVersion.'/'.$this->datasetName.'/' . $this->datasetVersion, $params);
        return new Collection($data);
    }
}
