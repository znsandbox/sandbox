<?php

namespace ZnSandbox\Sandbox\Application\Symfony4\Admin\Controllers;

use ZnSandbox\Sandbox\Application\Domain\Interfaces\Services\ApplicationServiceInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnLib\Web\Components\Url\Helpers\Url;
use ZnLib\Web\Components\Controller\BaseWebCrudController;
use ZnLib\Web\Components\Controller\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Components\TwBootstrap\Widgets\Breadcrumb\BreadcrumbWidget;

class ApplicationController extends BaseWebCrudController implements ControllerAccessInterface
{

    protected $viewsDir = __DIR__ . '/../views/application';
    protected $baseUri = '/application/application';

    public function __construct(
        ToastrServiceInterface $toastrService,
        FormFactoryInterface $formFactory,
        CsrfTokenManagerInterface $tokenManager,
        BreadcrumbWidget $breadcrumbWidget,
        ApplicationServiceInterface $service
    )
    {
        $this->setService($service);
        $this->setToastrService($toastrService);
        $this->setFormFactory($formFactory);
        $this->setTokenManager($tokenManager);
        $this->setBreadcrumbWidget($breadcrumbWidget);

        $title = 'Application';
        $this->getBreadcrumbWidget()->add($title, Url::to([$this->getBaseUri()]));
    }
}
