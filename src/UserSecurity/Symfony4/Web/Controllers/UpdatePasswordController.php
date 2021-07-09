<?php

namespace ZnSandbox\Sandbox\UserSecurity\Symfony4\Web\Controllers;

use ZnSandbox\Sandbox\UserSecurity\Domain\Forms\CreatePasswordForm;
use ZnSandbox\Sandbox\UserSecurity\Domain\Forms\RequestActivationCodeForm;
use ZnSandbox\Sandbox\UserSecurity\Domain\Forms\UpdatePasswordForm;
use ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Services\RestorePasswordServiceInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnCore\Base\Exceptions\AlreadyExistsException;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnLib\Web\Symfony4\MicroApp\BaseWebController;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Symfony4\MicroApp\Traits\ControllerFormTrait;
use ZnSandbox\Sandbox\UserSecurity\Domain\Enums\Rbac\SecurityPermissionEnum;
use ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Services\UpdatePasswordServiceInterface;
use ZnSandbox\Sandbox\UserSecurity\Symfony4\Web\Enums\WebUserSecurityEnum;

class UpdatePasswordController extends BaseWebController implements ControllerAccessInterface
{

    use ControllerFormTrait;

    protected $viewsDir = __DIR__ . '/../views/update-password';
    protected $toastrService;
    protected $service;
    protected $session;

    public function __construct(
        UpdatePasswordServiceInterface $restorePasswordService,
        ToastrServiceInterface $toastrService,
        SessionInterface $session,
        FormFactoryInterface $formFactory,
        CsrfTokenManagerInterface $tokenManager
    )
    {
        $this->service = $restorePasswordService;
        $this->toastrService = $toastrService;
        $this->session = $session;
        $this->setFormFactory($formFactory);
        $this->setTokenManager($tokenManager);
    }

    public function access(): array
    {
        return [
            'updatePassword' => [
                SecurityPermissionEnum::UPDATE_PASSWORD_UPDATE,
            ],
        ];
    }

    public function updatePassword(Request $request): Response
    {
        $form = new UpdatePasswordForm();
        $buildForm = $this->buildForm($form, $request);
        if ($buildForm->isSubmitted() && $buildForm->isValid()) {
            try {
                $this->service->update($form);
                $this->toastrService->success(['user_security', 'restore-password.message.create_password_success']);
                return $this->redirectToHome();
            } catch (UnprocessibleEntityException $e) {
                $this->setUnprocessableErrorsToForm($buildForm, $e);
            }
        }

        return $this->render('update-password', [
            'formView' => $buildForm->createView(),
        ]);
    }
}
