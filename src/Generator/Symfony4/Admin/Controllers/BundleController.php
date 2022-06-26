<?php

namespace ZnSandbox\Sandbox\Generator\Symfony4\Admin\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\TestBrowserToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use ZnCore\Domain\Entity\Helpers\CollectionHelper;
use ZnCore\Base\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Entity\Helpers\EntityHelper;
use ZnLib\Rpc\Domain\Enums\RpcErrorCodeEnum;
use ZnLib\Web\Symfony4\MicroApp\BaseWebController;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Components\Form\Libs\FormManager;
use ZnLib\Web\Components\Layout\Libs\LayoutManager;
use ZnSandbox\Sandbox\Bundle\Domain\Interfaces\Services\BundleServiceInterface;
use ZnSandbox\Sandbox\Generator\Domain\Helpers\TableMapperHelper;
use ZnDatabase\Base\Domain\Repositories\Eloquent\SchemaRepository;
use ZnLib\Rpc\Domain\Entities\MethodEntity;
use ZnLib\Rpc\Domain\Interfaces\Services\MethodServiceInterface;
use ZnSandbox\Sandbox\Generator\Domain\Entities\FavoriteEntity;
use ZnSandbox\Sandbox\Generator\Domain\Helpers\FavoriteHelper;
use ZnSandbox\Sandbox\Generator\Domain\Interfaces\Services\ClientServiceInterface;
use ZnSandbox\Sandbox\Generator\Domain\Interfaces\Services\FavoriteServiceInterface;
use ZnSandbox\Sandbox\Generator\Symfony4\Admin\Forms\ImportForm;
use ZnSandbox\Sandbox\Generator\Symfony4\Admin\Forms\RequestForm;
use ZnUser\Rbac\Domain\Enums\Rbac\ExtraPermissionEnum;

class BundleController extends BaseWebController implements ControllerAccessInterface
{

    protected $viewsDir = __DIR__ . '/../views/bundle';
    protected $baseUri = '/generator/bundle';
    protected $formClass = RequestForm::class;
    private $clientService;
    private $favoriteService;
    private $methodService;
    private $layoutManager;
    private $bundleService;
    private $schemaRepository;

    public function __construct(
        FormManager $formManager,
        LayoutManager $layoutManager,
        UrlGeneratorInterface $urlGenerator,
        SchemaRepository $schemaRepository,
        BundleServiceInterface $bundleService
    )
    {
        $this->setFormManager($formManager);
        $this->setLayoutManager($layoutManager);
        $this->setUrlGenerator($urlGenerator);
        $this->setBaseRoute('generator/bundle');

        $this->bundleService = $bundleService;
        $this->schemaRepository = $schemaRepository;

        $this->getLayoutManager()->addBreadcrumb('Generator', 'generator/bundle');
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
            'index' => [
                ExtraPermissionEnum::ADMIN_ONLY,
            ],
            'view' => [
                ExtraPermissionEnum::ADMIN_ONLY,
            ],
        ];
    }

    public function index(Request $request): Response
    {
        $bundleCollection = $this->bundleService->all();
        //dd($bundleCollection);
        return $this->render('index', [
            'bundleCollection' => $bundleCollection,
        ]);
    }

    public function view(Request $request): Response
    {
        $id = $request->query->get('id');
        $bundleEntity = $this->bundleService->oneById($id);
//dd($bundleEntity);

        if($bundleEntity->getDomain()) {

        }
        $tableCollection = $this->schemaRepository->allTables();
        $tableList = CollectionHelper::getColumn($tableCollection, 'name');
        $entityNames = [];
        foreach ($tableList as $tableName) {
            $bundleName = TableMapperHelper::extractDomainNameFromTable($tableName);
            if ($bundleEntity->getDomain()->getName() == $bundleName) {
                $entityNames[] = TableMapperHelper::extractEntityNameFromTable($tableName);
            }
        }
        dd($entityNames);

    }
}
