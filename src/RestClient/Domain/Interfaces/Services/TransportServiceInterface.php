<?php

namespace PhpLab\Sandbox\RestClient\Domain\Interfaces\Services;

use PhpLab\Sandbox\RestClient\Domain\Entities\ProjectEntity;
use Psr\Http\Message\ResponseInterface;
use PhpLab\Sandbox\RestClient\Yii\Web\models\RequestForm;

interface TransportServiceInterface
{

    public function send(ProjectEntity $projectEntity, RequestForm $model): ResponseInterface;

}

