<?php

namespace ZnSandbox\Sandbox\Apache\Symfony4\Web\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZnLib\Web\Symfony4\MicroApp\BaseWebController;
use ZnLib\Web\Symfony4\MicroApp\BaseWebCrudController;
use ZnSandbox\Sandbox\Apache\Domain\Services\ServerService;

class ServerController extends BaseWebCrudController
{

    protected $viewsDir = __DIR__ . '/../views/server';
    protected $baseUri = '/apache/server';
    private $serverService;

    public function __construct(
        ServerService $serverService
    )
    {
        $this->serverService = $serverService;
    }

    public function index(Request $request): Response
    {
        $collection = $this->serverService->all();
        return $this->render('index', [
            'collection' => $collection,
            'baseUri' => $this->baseUri,
        ]);
    }

    public function view(Request $request): Response
    {
        dd($request);
        $name = $request->query->get('id');
        $entity = $this->serverService->oneByName($name);
        return $this->render('view', [
            'entity' => $entity,
        ]);
    }
}
