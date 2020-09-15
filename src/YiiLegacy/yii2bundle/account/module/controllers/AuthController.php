<?php
namespace yii2bundle\account\module\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii2bundle\applicationTemplate\common\enums\ApplicationPermissionEnum;
use ZnBundle\User\Domain\Services\AuthService2;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnSandbox\Sandbox\Yii2\Helpers\Behavior;
use yii2bundle\account\domain\v3\forms\LoginForm;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets\Alert;
use yii2bundle\account\domain\v3\helpers\AuthHelper;
use yii\web\Response;

/**
 * AuthController controller
 */
class AuthController extends Controller
{
	public $defaultAction = 'login';
	private $authService;

	public function __construct($id, $module, $config = [], AuthService2 $authService)
    {
        parent::__construct($id, $module, $config);
        $this->authService = $authService;
    }

    /**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'actions' => ['logout', 'get-token'],
						'allow' => true,
						'roles' => ['@'],
					],
					[
						'actions' => ['login'],
						'allow' => true,
						'roles' => ['?'],
					],
				],
			],
			'verb' => Behavior::verb([
				'logout' => ['post'],
			]),
		];
	}

	/**
	 * Logs in a user.
	 */
	public function actionLogin()
	{
		$form = new LoginForm();
		$body = Yii::$app->request->post();
		$isValid = $form->load($body) && $form->validate();
		if ($isValid) {
			try {
				//\App::$domain->account->auth->authenticationFromWeb($form);
                $this->authService->authenticationByForm($form);
				if(!$this->isBackendAccessAllowed()) {
					$this->authService->logout();
					\ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets\Alert::create(['user', 'auth.login_access_error'], Alert::TYPE_DANGER);
					return $this->goHome();
				}
				\ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets\Alert::create(['user', 'auth.login_success'], Alert::TYPE_SUCCESS);
				return $this->goBack();
			} catch(UnprocessibleEntityException $e) {
				$form->addErrorsFromException2($e);
			}
		}
		
		return $this->render('login', [
			'model' => $form,
		]);
	}

	/**
	 * Logs out the current user.
	 */
	public function actionLogout($redirect = null)
	{
		$this->authService->logout();
		\ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets\Alert::create(['user', 'auth.logout_success'], Alert::TYPE_SUCCESS);
		if($redirect) {
            return $this->redirect([SL . $redirect]);
        } else {
            return $this->goHome();
        }
	}

    public function actionGetToken()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return AuthHelper::getTokenString();
    }

	private function isBackendAccessAllowed()
	{
		if(APP != BACKEND) {
			return true;
		}
		if (Yii::$app->user->can(ApplicationPermissionEnum::BACKEND_ALL)) {
			return true;
		}
		return false;
	}
	
}
