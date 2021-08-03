<?php

namespace ZnSandbox\Sandbox\Rpc\Symfony4\Web\Controllers;

use ZnSandbox\Sandbox\Rpc\Domain\Enums\Rbac\RpcDocPermissionEnum;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnLib\Rpc\Domain\Interfaces\Services\DocsServiceInterface;
use ZnLib\Web\Symfony4\MicroApp\BaseWebController;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Widgets\BreadcrumbWidget;

class DocsController extends BaseWebController implements ControllerAccessInterface
{

    private $docsService;
    protected $breadcrumbWidget;
    protected $viewsDir = __DIR__ . '/../views/front';

    public function __construct(
        DocsServiceInterface $docsService,
        BreadcrumbWidget $breadcrumbWidget
    )
    {
        $this->docsService = $docsService;
        $this->breadcrumbWidget = $breadcrumbWidget;
        $title = 'JSON RPC';
        $this->breadcrumbWidget->add($title, Url::to(['/json-rpc']));
//        $this->getView()->addAttribute('title', $title);
    }

    public function access(): array
    {
        return [
            'index' => [
                RpcDocPermissionEnum::ALL
            ],
            'view' => [
                RpcDocPermissionEnum::ONE
            ],
            'download' => [
                RpcDocPermissionEnum::DOWNLOAD
            ],
        ];
    }

    public function index(Request $request): Response
    {
        $this->breadcrumbWidget->add('List docs', Url::to(['/json-rpc']));
        //$this->layout = __DIR__ . '/../../../../Common/views/layouts/main.php';
        $docs = $this->docsService->all();
        return $this->render('index', [
            'docs' => $docs,
        ]);
    }

    public function view(Request $request): Response
    {
        $name = $request->query->get('name', 'index');
        $docsHtml = $this->docsService->loadByName($name);
        return new Response($docsHtml);
    }

    public function download(Request $request): Response
    {
        $name = $request->query->get('name', 'index');
        $docsHtml = $this->docsService->loadByName($name);

        $entity = $this->docsService->oneByName($name);
        $response = new Response($docsHtml);
        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $name . '_' . FileHelper::fileFromTime() . '.html'
        );
        $response->headers->set('Content-Disposition', $disposition);
        return $response;
    }
}
