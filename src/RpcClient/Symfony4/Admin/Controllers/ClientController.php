<?php

namespace ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use ZnCore\Base\Status\Enums\StatusEnum;
use ZnCore\Domain\Entity\Helpers\CollectionHelper;
use ZnCore\Base\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Entity\Helpers\EntityHelper;
use ZnLib\Rpc\Domain\Entities\MethodEntity;
use ZnLib\Rpc\Domain\Enums\RpcErrorCodeEnum;
use ZnLib\Rpc\Domain\Interfaces\Services\MethodServiceInterface;
use ZnLib\Web\Symfony4\MicroApp\BaseWebController;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Symfony4\MicroApp\Libs\FormManager;
use ZnLib\Web\Symfony4\MicroApp\Libs\LayoutManager;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Enums\Rbac\RpcClientFavoritePermissionEnum;
use ZnSandbox\Sandbox\RpcClient\Domain\Enums\Rbac\RpcClientHistoryPermissionEnum;
use ZnSandbox\Sandbox\RpcClient\Domain\Enums\Rbac\RpcClientRequestPermissionEnum;
use ZnSandbox\Sandbox\RpcClient\Domain\Helpers\FavoriteHelper;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\ClientServiceInterface;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\FavoriteServiceInterface;
use ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Forms\ImportForm;
use ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Forms\RequestForm;

class ClientController extends BaseWebController implements ControllerAccessInterface
{

    protected $viewsDir = __DIR__ . '/../views/client';
    protected $baseUri = '/rpc-client/request';
    protected $formClass = RequestForm::class;
    private $clientService;
    private $favoriteService;
    private $methodService;
    private $layoutManager;

    public function __construct(
        FormManager $formManager,
        LayoutManager $layoutManager,
        UrlGeneratorInterface $urlGenerator,
        ClientServiceInterface $clientService,
        FavoriteServiceInterface $favoriteService,
        MethodServiceInterface $methodService
    )
    {
        $this->setFormManager($formManager);
        $this->setLayoutManager($layoutManager);
        $this->setUrlGenerator($urlGenerator);
        $this->setBaseRoute('rpc-client/request');

        $this->clientService = $clientService;
        $this->favoriteService = $favoriteService;
        $this->methodService = $methodService;

        $this->getLayoutManager()->addBreadcrumb('Rpc client', 'rpc-client/request');
    }

    /*public function with(): array
    {
        return [
            'application',
        ];
    }*/

    public function access(): array
    {
        return [
            'request' => [
                RpcClientRequestPermissionEnum::SEND,
            ],
            'clearHistory' => [
                RpcClientHistoryPermissionEnum::DELETE,
            ],
            'importFromRoutes' => [
                RpcClientFavoritePermissionEnum::CREATE,
            ],
            'allRoutes' => [
                RpcClientFavoritePermissionEnum::ALL,
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
            $favoriteEntity = $this->favoriteService->oneById($id);
        } else {
            $favoriteEntity = new FavoriteEntity();
        }

        FavoriteHelper::entityToForm($favoriteEntity, $form);

        $buildForm = $this->getFormManager()->buildForm($form, $request);
        if ($buildForm->isSubmitted() && $buildForm->isValid()) {
            $action = $buildForm->getClickedButton()->getConfig()->getName();
            if ($action == 'save') {
                try {
                    $rpcResponseEntity = $this->clientService->sendRequest($form, $favoriteEntity);

                    if ($rpcResponseEntity->getError() && $rpcResponseEntity->getError()['code'] == RpcErrorCodeEnum::SERVER_ERROR_METHOD_NOT_FOUND) {
                        $e = new UnprocessibleEntityException();
                        $e->add('version', $rpcResponseEntity->getError()['message']);
                        $e->add('method', $rpcResponseEntity->getError()['message']);
                        $this->getFormManager()->setUnprocessableErrorsToForm($buildForm, $e);
                    }

                    $rpcRequestEntity = $this->clientService->formToRequestEntity($form);
                } catch (UnprocessibleEntityException $e) {
                    $this->getFormManager()->setUnprocessableErrorsToForm($buildForm, $e);
                }
            } elseif ($action == 'persist') {
                if ($id) {
                    $favoriteEntity = $this->favoriteService->oneById($id);
                }
                $favoriteEntity = FavoriteHelper::formToEntity($form, $favoriteEntity);
                $this->favoriteService->addFavorite($favoriteEntity);
                $this->getLayoutManager()->toastrSuccess('Added to favorite!');
                return $this->redirectToRoute('rpc-client/request', ['id' => $favoriteEntity->getId()]);
            } elseif ($action == 'delete') {
                if ($id) {
                    $this->favoriteService->deleteById($id);
                    $this->getLayoutManager()->toastrSuccess('Deleted!');
                    return $this->redirectToRoute('rpc-client/request');
                }
            }
        }

        $favoriteCollection = $this->favoriteService->allFavorite();
        $historyCollection = $this->favoriteService->allHistory();

        return $this->render('index', [
            'favoriteEntity' => $favoriteEntity,
            'rpcResponseEntity' => $rpcResponseEntity ?? null,
            'rpcRequestEntity' => $rpcRequestEntity ?? null,
            'favoriteCollection' => $favoriteCollection,
            'historyCollection' => $historyCollection,
            'baseUri' => $this->getBaseUri(),
            //'formView' => $buildForm->createView(),
            'formRender' => $this->getFormManager()->createFormRender($buildForm),
//            'filterModel' => $filterModel,
        ]);
    }

    public function clearHistory(Request $request): Response
    {
        $this->favoriteService->clearHistory();
        $this->getLayoutManager()->toastrSuccess('Clear history!');
        return $this->redirectToRoute('rpc-client/request');
    }

    public function importFromRoutes(Request $request): Response
    {
        /** @todo перенести в новый сервис */
        $methodCollection = $this->methodService->all();
        /** @var MethodEntity[] $methodCollectionIndexed */
        $methodCollectionIndexed = CollectionHelper::indexing($methodCollection, 'methodName');
        $routeMethodList = CollectionHelper::getColumn($methodCollection, 'methodName');
        $routeMethodList = array_values($routeMethodList);

        $favoriteCollection = $this->favoriteService->allFavorite();
        $favoriteCollectionIndexed = CollectionHelper::indexing($favoriteCollection, 'method');
        $favoriteMethodList = CollectionHelper::getColumn($favoriteCollection, 'method');
        $favoriteMethodList = array_unique($favoriteMethodList);
        $favoriteMethodList = array_values($favoriteMethodList);

        $missingMethodList = array_diff($routeMethodList, $favoriteMethodList);

        /** @var ImportForm $form */
        $form = $this->createFormInstance(ImportForm::class);

        $buildForm = $this->getFormManager()->buildForm($form, $request);
        if ($buildForm->isSubmitted() && $buildForm->isValid()) {
            if ($missingMethodList) {
                foreach ($missingMethodList as $methodName) {
                    $favoriteEntity = new FavoriteEntity();
                    $methodEntity = $methodCollectionIndexed[$methodName];
                    $favoriteEntity->setMethod($methodName);
                    $favoriteEntity->setDescription($methodEntity->getTitle());
                    if ($methodEntity->getIsVerifyAuth()) {
                        /** @todo: собрать коллекцию пользователей по имеи полномочия, назначить первого пользователя */
                        $favoriteEntity->setAuthBy(1);
                    }
                    $this->favoriteService->addHistory($favoriteEntity);
                }
                $this->getLayoutManager()->toastrSuccess('Import completed successfully!');
                return $this->redirectToRoute('rpc-client/request');
            }
        }

        $favCollection = [];
        foreach ($methodCollectionIndexed as $methodEntity) {
            if (in_array($methodEntity->getMethodName(), $missingMethodList)) {
                $favEntity = new \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity();
                $favEntity->setMethod($methodEntity->getMethodName());
                $favEntity->setDescription($methodEntity->getTitle());
                if ($methodEntity->getIsVerifyAuth()) {
                    $favEntity->setAuthBy(1);
                }
                $favCollection[] = $favEntity;
            }
        }

        return $this->render('import-from-routes', [
            'missingMethodList' => $missingMethodList,
            'routeMethodList' => $routeMethodList,
            'favCollection' => $favCollection,
            'methodCollectionIndexed' => $methodCollectionIndexed,
            'formRender' => $this->getFormManager()->createFormRender($buildForm),
        ]);
    }

    public function allRoutes(Request $request): Response
    {
        /** @todo перенести в новый сервис */
        $methodCollection = $this->methodService->all();
        /** @var MethodEntity[] $methodCollectionIndexed */
        $methodCollectionIndexed = CollectionHelper::indexing($methodCollection, 'methodName');
        $routeMethodList = CollectionHelper::getColumn($methodCollection, 'methodName');
        $routeMethodList = array_values($routeMethodList);

        $favoriteCollection = $this->favoriteService->allFavorite();
        $favoriteCollectionIndexed = CollectionHelper::indexing($favoriteCollection, 'method');
        $favoriteMethodList = CollectionHelper::getColumn($favoriteCollection, 'method');
        $favoriteMethodList = array_unique($favoriteMethodList);
        $favoriteMethodList = array_values($favoriteMethodList);

        $missingMethodList = array_diff($routeMethodList, $favoriteMethodList);

        /** @var ImportForm $form */
        $form = $this->createFormInstance(ImportForm::class);

        $buildForm = $this->getFormManager()->buildForm($form, $request);
        if ($buildForm->isSubmitted() && $buildForm->isValid()) {
//            if ($missingMethodList) {
//                foreach ($missingMethodList as $methodName) {
//                    $favoriteEntity = new FavoriteEntity();
//                    $methodEntity = $methodCollectionIndexed[$methodName];
//                    $favoriteEntity->setMethod($methodName);
//                    if ($methodEntity->getIsVerifyAuth()) {
//                        /** @todo: собрать коллекцию пользователей по имеи полномочия, назначить первого пользователя */
//                        $favoriteEntity->setAuthBy(1);
//                    }
//                    $this->favoriteService->addFavorite($favoriteEntity);
//                }
//                $this->getLayoutManager()->toastrSuccess('Import completed successfully!');
//                return $this->redirectToRoute('rpc-client/request');
//            }
        }

        $favCollection = [];
        foreach ($methodCollectionIndexed as $methodEntity) {
            $favEntity = new \ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity();
            $favEntity->setMethod($methodEntity->getMethodName());
            $favEntity->setDescription($methodEntity->getTitle());
            if ($methodEntity->getIsVerifyAuth()) {
                $favEntity->setAuthBy(1);
            }
            $favCollection[] = $favEntity;
        }

        return $this->render('import-from-routes', [
            'missingMethodList' => $missingMethodList,
            'routeMethodList' => $routeMethodList,
            'favCollection' => $favCollection,
            'methodCollectionIndexed' => $methodCollectionIndexed,
            'formRender' => $this->getFormManager()->createFormRender($buildForm),
        ]);
    }
}
