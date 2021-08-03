<?php

namespace ZnSandbox\Sandbox\Rpc\Symfony4\Web\Controllers;

use App\Common\Enums\Rbac\CommonPermissionEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZnLib\Web\Symfony4\MicroApp\BaseWebController;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\ControllerAccessInterface;

class DefaultController extends BaseWebController implements ControllerAccessInterface
{

    //protected $layout = __DIR__ . '/../../../../Common/views/layouts/main.php';
    protected $viewsDir = __DIR__ . '/../views/default';

    public function access(): array
    {
        return [
            'index' => [
                CommonPermissionEnum::MAIN_PAGE_VIEW,
            ],
        ];
    }

    public function index(Request $request): Response
    {
        return $this->render('index');
    }
}
