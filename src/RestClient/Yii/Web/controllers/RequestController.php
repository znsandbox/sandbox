<?php

namespace PhpLab\Sandbox\RestClient\Yii\Web\controllers;

use PhpLab\Core\Enums\Http\HttpHeaderEnum;
use PhpLab\Core\Helpers\UploadHelper;
use PhpLab\Core\Libs\I18Next\Interfaces\Services\TranslationServiceInterface;
use PhpLab\Sandbox\RestClient\Domain\Entities\BookmarkEntity;
use PhpLab\Sandbox\RestClient\Domain\Enums\RestClientPermissionEnum;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\TransportServiceInterface;
use PhpLab\Sandbox\RestClient\Yii\Web\helpers\AdapterHelper;
use PhpLab\Sandbox\RestClient\Yii\Web\models\RequestForm;
use PhpLab\Test\Helpers\RestHelper;
use PhpLab\Rest\Helpers\RestResponseHelper;
use Yii;
use yii\base\Module;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\EnvironmentServiceInterface;

/**
 * Class RequestController
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
class RequestController extends BaseController
{
    /**
     * @var \PhpLab\Sandbox\RestClient\Yii\Web\Module
     */
    public $module;
    /**
     * @inheritdoc
     */
    public $defaultAction = 'create';

    protected $bookmarkService;
    protected $projectService;
    protected $transportService;
    protected $translationService;
    protected $authorizationService;
    protected $identityService;
    protected $accessService;

    public function __construct(
        $id, Module $module,
        array $config = [],
        BookmarkServiceInterface $bookmarkService,
        ProjectServiceInterface $projectService,
        TransportServiceInterface $transportService
    )
    {
        parent::__construct($id, $module, $config);
        $this->bookmarkService = $bookmarkService;
        $this->projectService = $projectService;
        $this->transportService = $transportService;
    }

    public function authentication(): array
    {
        return [
            'send',
        ];
    }

    public function access(): array
    {
        return [
            [
                [RestClientPermissionEnum::PROJECT_READ], ['send'],
            ],
        ];
    }

    public function actionSend(string $projectName, $tag = null)
    {
        /** @var RequestForm $model */
        $model = Yii::createObject(RequestForm::class);
        $projectEntity = $this->getProjectByName($projectName);
        $response = null;
        $duration = null;
        if ($tag !== null) {
            /** @var BookmarkEntity $bookmarkEntity */
            $bookmarkEntity = $this->bookmarkService->oneByHash($tag);
            $model = AdapterHelper::bookmarkEntityToForm($bookmarkEntity);
        } elseif (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post(), 'RequestForm');
            $model->baseUrl = Yii::$app->request->post('RequestForm')['baseUrl'];
            //dd($model);
            //dd(Yii::$app->request->post('RequestForm')['baseUrl']);
            if ($model->validate()) {
                $model->files = UploadHelper::createUploadedFileArray($_FILES);

                //dd(Yii::$app->request->post());

                $begin = microtime(true);
                $response = $this->transportService->send($projectEntity, $model);
                $duration = microtime(true) - $begin;

                $bookmarkEntity = AdapterHelper::formToBookmarkEntityData($model);
                $bookmarkEntity->setProjectId($projectEntity->getId());
                $this->bookmarkService->persist($bookmarkEntity);
                $tag = $bookmarkEntity->getHash();

                $contentDisposition = RestResponseHelper::extractHeaderValues($response, HttpHeaderEnum::CONTENT_DISPOSITION);
                //$contentDisposition = $response->getHeader('Content-Disposition')[0] ?? null;

                if ($contentDisposition != null) {
                    //$ee = explode(';', $contentDisposition);
                    if ($contentDisposition[0] == 'attachment') {
                        Yii::$app->response->headers->fromArray($response->getHeaders());
                        return $response->getBody()->getContents();
                    } /*elseif($ee[0] == 'inline') {
			    $requestEntity = AdapterHelper::createRequestEntityFromForm($model);
			    $requestEntity->headers['Authorization'] = ;
			    //prr($requestEntity,1,1);
			    $frame = $this->module->baseUrl . SL . $requestEntity->uri;
		    }*/
                }
            }
        }

        $frame = null; // 'http://docs.guzzlephp.org/en/stable/quickstart.html#uploading-data';

        return $this->render('create', [
            'tag' => $tag,
            'model' => $model,
            'response' => $response,
            'frame' => $frame,
            'projectEntity' => $projectEntity,
            'duration' => $duration,
           // 'environmentCollection' => $this->environmentService->allByProjectId($projectEntity->getId()),
        ]);
    }

}