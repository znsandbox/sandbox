<?php

namespace PhpLab\Sandbox\Dashboard\Symfony\Api\Controllers;

use PhpLab\Core\Exceptions\NotFoundException;
use PhpLab\Sandbox\Dashboard\Domain\Interfaces\Services\DocServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DocController extends AbstractController
{

    private $docService;

    public function __construct(DocServiceInterface $docService)
    {
        if($_ENV['APP_ENV'] == 'prod') {
            throw new NotFoundHttpException('Deny for production!');
        }
        $this->docService = $docService;
    }

    public function index()
    {
        $versionList = $this->docService->versionList();
        $html = '<ul>';
        foreach ($versionList as $version) {
            $html .= "<li><a href=\"/api/v$version\">API version $version</a></li>";
        }
        $html .= '</ul>';
        return new Response($html);
    }

    public function show($version)
    {
        try {
            $htmlContent = $this->docService->htmlByVersion($version);
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException("Not found API documentation for version v{$version}!");
        }
        return new Response($htmlContent);
    }

}
