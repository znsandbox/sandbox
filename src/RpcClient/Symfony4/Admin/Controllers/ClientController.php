<?php

namespace ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Controllers;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Exceptions\AlreadyExistsException;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Rpc\Domain\Enums\RpcErrorCodeEnum;
use ZnLib\Rpc\Domain\Libs\RpcClient;
use ZnLib\Web\Symfony4\MicroApp\BaseWebCrudController;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Symfony4\MicroApp\Libs\FormRender;
use ZnLib\Web\Widgets\BreadcrumbWidget;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Filters\ApiKeyFilter;
use ZnSandbox\Sandbox\RpcClient\Domain\Helpers\FavoriteHelper;
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
    private $favoriteService;

    public function __construct(
        ToastrServiceInterface $toastrService,
        FormFactoryInterface $formFactory,
        CsrfTokenManagerInterface $tokenManager,
        BreadcrumbWidget $breadcrumbWidget,
        FavoriteServiceInterface $service,
        ClientServiceInterface $clientService,
        FavoriteServiceInterface $favoriteService,
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
        $this->favoriteService = $favoriteService;

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
            'clearHistory' => [
                ExtraPermissionEnum::ADMIN_ONLY,
            ],
        ];
    }

    public function request(Request $request): Response
    {
        $id = $request->query->get('id');
        /** @var RequestForm $form */
        $form = $this->createFormInstance();

        if ($id) {
            /** @var FavoriteEntity $favoriteEntity */
            $favoriteEntity = $this->service->oneById($id);
        } else {
            $favoriteEntity = new FavoriteEntity();
        }
        $form->setMethod($favoriteEntity->getMethod());
        $form->setMeta(json_encode($favoriteEntity->getMeta()));
        $form->setBody(json_encode($favoriteEntity->getBody()));
        $form->setAuthBy($favoriteEntity->getAuthBy());
        $form->setDescription($favoriteEntity->getDescription());
        $form->setVersion($favoriteEntity->getVersion());

        $buildForm = $this->buildForm($form, $request);
        if ($buildForm->isSubmitted() && $buildForm->isValid()) {
            $action = $buildForm->getClickedButton()->getConfig()->getName();
            if($action == 'save') {
                try {
                    $rpcResponseEntity = $this->clientService->sendRequest($form, $favoriteEntity);

                    if ($rpcResponseEntity->getError() && $rpcResponseEntity->getError()['code'] == RpcErrorCodeEnum::SERVER_ERROR_METHOD_NOT_FOUND) {
                        $e = new UnprocessibleEntityException();
                        $e->add('version', $rpcResponseEntity->getError()['message']);
                        $e->add('method', $rpcResponseEntity->getError()['message']);
                        $this->setUnprocessableErrorsToForm($buildForm, $e);
                    }

                    $rpcRequestEntity = $this->clientService->formToRequestEntity($form);
                } catch (UnprocessibleEntityException $e) {
                    $this->setUnprocessableErrorsToForm($buildForm, $e);
                }
            } elseif ($action == 'persist') {
                if($id) {
                    $favoriteEntity = $this->favoriteService->oneById($id);
                }
                $favoriteEntity = FavoriteHelper::formToEntity($form, $favoriteEntity);
                $this->favoriteService->addFavorite($favoriteEntity);
                $this->getToastrService()->success('Added to favorite!');
                return $this->redirect(Url::to([$this->getBaseUri(), 'id' => $favoriteEntity->getId()]));
            } elseif ($action == 'delete') {
                if($id) {
                    $this->favoriteService->deleteById($id);
                    $this->getToastrService()->success('Deleted!');
                    return $this->redirect(Url::to([$this->getBaseUri()]));
                }
            }
        }

        /*try {
            $this->getService()->oneByUnique();
        } catch (NotFoundException $e) {

        }*/

        $favoriteCollection = $this->getService()->allFavorite();
        $historyCollection = $this->getService()->allHistory();

        $formRender = new FormRender($buildForm->createView(), $this->getTokenManager());

        return $this->render('index', [
            'favoriteEntity' => $favoriteEntity,
            'rpcResponseEntity' => $rpcResponseEntity ?? null,
            'rpcRequestEntity' => $rpcRequestEntity ?? null,
            'favoriteCollection' => $favoriteCollection,
            'historyCollection' => $historyCollection,
            'baseUri' => $this->getBaseUri(),
            //'formView' => $buildForm->createView(),
            'formRender' => $formRender,
//            'filterModel' => $filterModel,
        ]);
    }

    public function clearHistory(Request $request): Response
    {
        $this->getService()->clearHistory();
        $this->getToastrService()->success('Clear history!');
        return $this->redirect(Url::to([$this->getBaseUri()]));
    }
}
