<?php

namespace ZnSandbox\Sandbox\Synchronize\Symfony4\Admin\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZnCore\Base\Enums\Http\HttpMethodEnum;
use ZnLib\Web\Symfony4\MicroApp\BaseWebController;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Symfony4\MicroApp\Libs\FormManager;
use ZnLib\Web\Symfony4\MicroApp\Libs\LayoutManager;
use ZnLib\Web\Symfony4\MicroApp\MicroApp;
use ZnSandbox\Sandbox\Synchronize\Domain\Interfaces\Services\SynchronizeServiceInterface;
use ZnUser\Rbac\Domain\Enums\Rbac\ExtraPermissionEnum;

class SynchronizeController extends BaseWebController implements ControllerAccessInterface
{

    protected $viewsDir = __DIR__ . '/../views/synchronize';
    protected $baseUri = '/synchronize';

    private $synchronizeService;

    public function __construct(
        FormManager $formManager,
        LayoutManager $layoutManager,
        SynchronizeServiceInterface $synchronizeService
    )
    {
        $this->setFormManager($formManager);
        $this->setLayoutManager($layoutManager);
        $this->synchronizeService = $synchronizeService;
        $title = 'Synchronize';
        // $this->getLayoutManager()->addBreadcrumb($title, $this->getBaseRoute() . '/index');
    }

    public function access(): array
    {
        return [
            'index' => [
                ExtraPermissionEnum::ADMIN_ONLY,
            ],
        ];
    }

    public function index(Request $request): Response
    {
        if ($request->getMethod() == HttpMethodEnum::POST) {
            $this->synchronizeService->sync();
            $this->getLayoutManager()->getToastrService()->success(['synchronize', 'synchronize.message.sync_success']);
        }
        $diffCollection = $this->synchronizeService->diff();
       // dd($diffCollection);
        return $this->render('index', [
            'diffCollection' => $diffCollection,
        ]);
    }
}
