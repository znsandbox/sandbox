<?php

namespace ZnSandbox\Sandbox\UserNotify\Yii2\Settings\Controllers;

use DomainException;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\SettingEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\SettingServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\TypeServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Yii2\Settings\Forms\TransportForm;
use Packages\Support\Domain\Interfaces\Services\CallMeServiceInterface;
use ZnBundle\Person\Domain\Interfaces\Services\ContactTypeServiceInterface;
use Yii;
use yii\base\Module;
use yii\helpers\Url;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnBundle\UserSettings\Yii2\Admin\Controllers\BaseSettingsController;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Libs\Query;
use ZnLib\Web\Widgets\BreadcrumbWidget;
use ZnYii\Base\Helpers\FormHelper;

class TransportController extends BaseSettingsController
{

    private $typeService;
    private $settingService;
    private $contactTypeService;
    public $viewAlias = '@vendor/znsandbox/sandbox/src/UserNotify/Yii2/Settings/views/transport/index.php';

    public function __construct(
        string $id,
        Module $module, array $config = [],
        BreadcrumbWidget $breadcrumbWidget,
        ContactTypeServiceInterface $contactTypeService,
        TypeServiceInterface $typeService,
        SettingServiceInterface $settingService,
        CallMeServiceInterface $service,
        ToastrServiceInterface $toastrService
    )
    {
        parent::__construct($id, $module, $config);
        //$this->service = $service;
        $this->settingService = $settingService;
        $this->contactTypeService = $contactTypeService;
        $this->typeService = $typeService;
        $this->toastrService = $toastrService;
        $this->breadcrumbWidget = $breadcrumbWidget;
        $this->breadcrumbWidget->add(I18Next::t('notify', 'settings.title'), Url::to(['/' . $this->route]));
    }

    public function actionIndex()
    {
        $typeQuery = new Query();
        $typeQuery->with(['i18n']);
        $typeCollection = $this->typeService->all($typeQuery);
        $contactTypeCollection = $this->contactTypeService->all();
//        dd($typeCollection);
        $model = new TransportForm();
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post($model->formName());
            //FormHelper::setAttributes($model, $postData);
            $model->setAttributes($postData);
            try {
                //$data = FormHelper::extractAttributesForEntity($model, PersonEntity::class);
                //$entity = EntityHelper::createEntity(PersonEntity::class, $data);
                $this->settingService->saveMySettings($postData);
                $this->toastrService->success(I18Next::t('settings', 'main.message.save_settings_success'));
            } catch (UnprocessibleEntityException $e) {
                $errors = FormHelper::setErrorsToModel($model, $e->getErrorCollection());
                $errorMessage = implode('<br/>', $errors);
                $this->toastrService->warning($errorMessage);
            } catch (DomainException $e) {
                $this->toastrService->warning($e->getMessage());
            }
        } else {
            /** @var SettingEntity[] $settingsCollection */
            $data = $this->settingService->getMySettings();
            /*$data = [];
            foreach ($settingsCollection as $settingsEntity) {
                $data[$settingsEntity->getNotifyTypeId()][$settingsEntity->getContactTypeId()] = $settingsEntity->getIsEnabled();
            }*/
            $model->setAttributes($data);
//            dd($data);
//            dd($settingsCollection);
            //$person = $this->authService->getIdentity();
            //$model->username = $person->getUserName();
        }
        return $this->render('index', [
            'model' => $model,
            'typeCollection' => $typeCollection,
            'contactTypeCollection' => $contactTypeCollection,
//            'settingsCollection' => $settingsCollection,
        ]);
    }

    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [SupportCallMePermissionEnum::ALL],
                        'actions' => ['index'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [SupportCallMePermissionEnum::ONE],
                        'actions' => ['view'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [SupportCallMePermissionEnum::CREATE],
                        'actions' => ['create'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [SupportCallMePermissionEnum::IN_PROGRESS],
                        'actions' => ['in-progress'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [SupportCallMePermissionEnum::COMPLETED],
                        'actions' => ['completed'],
                    ],
                ],
            ],
        ];
    }*/
}
