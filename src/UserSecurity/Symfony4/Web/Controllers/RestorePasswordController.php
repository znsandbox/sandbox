<?php

namespace ZnSandbox\Sandbox\UserSecurity\Symfony4\Web\Controllers;

use ZnSandbox\Sandbox\UserSecurity\Domain\Forms\CreatePasswordForm;
use ZnSandbox\Sandbox\UserSecurity\Domain\Forms\RequestActivationCodeForm;
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
use ZnSandbox\Sandbox\UserSecurity\Symfony4\Web\Enums\WebUserSecurityEnum;

class RestorePasswordController extends BaseWebController implements ControllerAccessInterface
{

    use ControllerFormTrait;

    protected $viewsDir = __DIR__ . '/../views/restore-password';
    protected $toastrService;
    protected $service;
    protected $session;

    public function __construct(
        RestorePasswordServiceInterface $restorePasswordService,
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
            'requestActivationCode' => [
                SecurityPermissionEnum::RESTORE_PASSWORD_REQUEST_ACTIVATION_CODE,
            ],
            'createPassword' => [
                SecurityPermissionEnum::RESTORE_PASSWORD_CREATE_PASSWORD,
            ],
        ];
    }

    public function requestActivationCode(Request $request): Response
    {
        $form = new RequestActivationCodeForm();

        $buildForm = $this->buildForm($form, $request);
        if ($buildForm->isSubmitted() && $buildForm->isValid()) {
            try {
                $this->service->requestActivationCode($form);
                $this->session->set(WebUserSecurityEnum::RESTORE_PASSWORD_EMAIL_SESSION_KEY, $form->getEmail());
                $this->toastrService->success(['user_security', 'restore-password.message.request_activation_code_success']);
                return $this->redirect('/restore-password/create-password');
            } catch (UnprocessibleEntityException $e) {
                $this->setUnprocessableErrorsToForm($buildForm, $e);
            } catch (AlreadyExistsException $e) {
                $message = $e->getMessage();
                $message .= ' ' . I18Next::t('user_security', 'restore-password.message.or_you_can_go_to_the_second_step');
                $message .= ' <a href="/restore-password/create-password">' . I18Next::t('user_security', 'restore-password.action.create_password') . '</a>';
                $buildForm->addError(new FormError($message));
            }
        }

        return $this->render('request-activation-code', [
            'formView' => $buildForm->createView(),
        ]);
    }

    public function createPassword(Request $request): Response
    {
        $form = new CreatePasswordForm();

        $email = $this->session->get(WebUserSecurityEnum::RESTORE_PASSWORD_EMAIL_SESSION_KEY);
        if (empty($email)) {
            $this->toastrService->success(['user_security', 'restore-password.message.session_expired']);
            return $this->redirect('/restore-password');
        }
        $form->setEmail($email);

        $buildForm = $this->buildForm($form, $request);
        if ($buildForm->isSubmitted() && $buildForm->isValid()) {
            try {
                $this->service->createPassword($form);
                $this->toastrService->success(['user_security', 'restore-password.message.create_password_success']);
                return $this->redirect('/');
            } catch (UnprocessibleEntityException $e) {
                $this->setUnprocessableErrorsToForm($buildForm, $e);
            }
        }

        return $this->render('create-password', [
            'formView' => $buildForm->createView(),
        ]);
    }
}
