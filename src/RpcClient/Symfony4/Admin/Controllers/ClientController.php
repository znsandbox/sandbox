<?php

namespace ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Helpers\QueryHelper;
use ZnCore\Domain\Libs\Query;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Libs\RpcClient;
use ZnLib\Rpc\Domain\Libs\RpcProvider;
use ZnLib\Web\Symfony4\MicroApp\Enums\CrudControllerActionEnum;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Filters\ApiKeyFilter;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\ApiKeyServiceInterface;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\FavoriteServiceInterface;
use ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Forms\ApiKeyForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnLib\Web\Symfony4\MicroApp\BaseWebCrudController;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Widgets\BreadcrumbWidget;
use ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Forms\RequestForm;
use ZnUser\Rbac\Domain\Enums\Rbac\ExtraPermissionEnum;

class ClientController extends BaseWebCrudController implements ControllerAccessInterface
{

    protected $viewsDir = __DIR__ . '/../views/client';
    protected $baseUri = '/rpc-client/request';
    protected $formClass = RequestForm::class;
    private $rpcClient;

    public function __construct(
        ToastrServiceInterface $toastrService,
        FormFactoryInterface $formFactory,
        CsrfTokenManagerInterface $tokenManager,
        BreadcrumbWidget $breadcrumbWidget,
        FavoriteServiceInterface $service,
        RpcClient $rpcClient
    )
    {
        $this->setService($service);
        $this->setToastrService($toastrService);
        $this->setFormFactory($formFactory);
        $this->setTokenManager($tokenManager);
        $this->setBreadcrumbWidget($breadcrumbWidget);
        $this->rpcClient = $rpcClient;

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
        /** @var RequestForm $form */
        $form = $this->createFormInstance();
        $buildForm = $this->buildForm($form, $request);
        if ($buildForm->isSubmitted() && $buildForm->isValid()) {
            try {
                $rpcRequestEntity = new RpcRequestEntity();
                $rpcRequestEntity->setMethod($form->getMethod());
                $rpcRequestEntity->setParams([
                    'body' => json_decode($form->getBody(), JSON_OBJECT_AS_ARRAY),
                    'meta' => json_decode($form->getMeta(), JSON_OBJECT_AS_ARRAY),
                ]);

                $this->rpcProvider = new RpcProvider();
                $rpcResponseEntity = $this->rpcProvider->sendRequestByEntity($rpcRequestEntity);

//                $this->rpcClient->getGuzzleClient()->
//                $this->rpcClient->sendRequestByEntity($rpcRequestEntity);


                $favoriteEntity = new FavoriteEntity();
                $favoriteEntity->setMethod($form->getMethod());
                $favoriteEntity->setBody($form->getBody());
                $favoriteEntity->setMeta($form->getMeta());
                $favoriteEntity->setDescription($form->getDescription());




                dd($favoriteEntity);
                //$this->getService()->updateById($id, EntityHelper::toArray($form));
                //$this->getToastrService()->success(['core', 'message.saved_success']);
                //return $this->redirect(Url::to([$this->getBaseUri()]));

            } catch (UnprocessibleEntityException $e) {
                $this->setUnprocessableErrorsToForm($buildForm, $e);
            }
        }

        $dataProvider = $this->getService()->getDataProvider();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'baseUri' => $this->getBaseUri(),
            'formView' => $buildForm->createView(),
//            'filterModel' => $filterModel,
        ]);
    }
}
