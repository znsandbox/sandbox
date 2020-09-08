<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services;

use ZnSandbox\Sandbox\RestClient\Domain\Entities\ProjectEntity;
use Psr\Http\Message\ResponseInterface;
use ZnSandbox\Sandbox\RestClient\Yii\Web\models\RequestForm;

interface TransportServiceInterface
{

    public function send(ProjectEntity $projectEntity, RequestForm $model): ResponseInterface;

}

