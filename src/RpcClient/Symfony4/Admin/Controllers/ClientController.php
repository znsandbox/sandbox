<?php

namespace ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Controllers;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnLib\Rpc\Domain\Libs\RpcClient;
use ZnLib\Web\Symfony4\MicroApp\BaseWebCrudController;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Widgets\BreadcrumbWidget;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Filters\ApiKeyFilter;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\ApiKeyServiceInterface;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\ClientServiceInterface;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\FavoriteServiceInterface;
use ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Forms\ApiKeyForm;
use ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Forms\RequestForm;
use ZnUser\Rbac\Domain\Enums\Rbac\ExtraPermissionEnum;

class ClientController extends BaseWebCrudController implements ControllerAccessInterface
{

    protected $viewsDir = __DIR__ . '/../views/client';
    protected $baseUri = '/rpc-client/request';
    protected $formClass = RequestForm::class;
    private $rpcClient;
    private $clientService;

    public function __construct(
        ToastrServiceInterface $toastrService,
        FormFactoryInterface $formFactory,
        CsrfTokenManagerInterface $tokenManager,
        BreadcrumbWidget $breadcrumbWidget,
        FavoriteServiceInterface $service,
        ClientServiceInterface $clientService,
        RpcClient $rpcClient
    )
    {
        $this->setService($service);
        $this->setToastrService($toastrService);
        $this->setFormFactory($formFactory);
        $this->setTokenManager($tokenManager);
        $this->setBreadcrumbWidget($breadcrumbWidget);
        $this->rpcClient = $rpcClient;
        $this->clientService = $clientService;

        //$this->setFilterModel(ApiKeyFilter::class);

        $title = 'Rpc client';
        $this->getBreadcrumbWidget()->add($title, Url::to([$this->getBaseUri()]));
    }

    public function with(): array
    {
        return [
            'application',
        ];
    }

    public function access(): array
    {
        return [
            'request' => [
                ExtraPermissionEnum::ADMIN_ONLY,
            ],
        ];
    }

    public function request(Request $request): Response
    {
        $id = $request->query->get('id');
        /** @var RequestForm $form */
        $form = $this->createFormInstance();

        if($id) {
            /** @var FavoriteEntity $favoriteEntity */
            $favoriteEntity = $this->service->oneById($id);
            $form->setMethod($favoriteEntity->getMethod());
            $form->setMeta(json_encode($favoriteEntity->getMeta()));
            $form->setBody(json_encode($favoriteEntity->getBody()));
            $form->setAuthBy($favoriteEntity->getAuthBy());
            $form->setDescription($favoriteEntity->getDescription());
        } else {
            $favoriteEntity = null;
        }

        $buildForm = $this->buildForm($form, $request);
        if ($buildForm->isSubmitted() && $buildForm->isValid()) {
            try {
                $rpcResponseEntity = $this->clientService->sendRequest($form, $favoriteEntity);
                $rpcRequestEntity = $this->clientService->formToRequestEntity($form);
            } catch (UnprocessibleEntityException $e) {
                $this->setUnprocessableErrorsToForm($buildForm, $e);
            }
        }

        $collection = $this->getService()->all();
        return $this->render('index', [
            'favoriteEntity' => $favoriteEntity,
            'rpcResponseEntity' => $rpcResponseEntity ?? null,
            'rpcRequestEntity' => $rpcRequestEntity ?? null,
            'collection' => $collection,
            'baseUri' => $this->getBaseUri(),
            'formView' => $buildForm->createView(),
//            'filterModel' => $filterModel,
        ]);
    }
}
