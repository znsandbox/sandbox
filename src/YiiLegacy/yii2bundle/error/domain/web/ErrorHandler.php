<?php

namespace yii2bundle\error\domain\web;

use ZnCore\Domain\Entities\ValidateErrorEntity;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Base\Enums\Http\HttpStatusCodeEnum;
use ZnCore\Base\Exceptions\NotFoundException;
use yii2rails\extension\scenario\collections\ScenarioCollection;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use yii2bundle\error\domain\helpers\UnProcessibleHelper;

class ErrorHandler extends \yii\web\ErrorHandler
{
	
	public $filters = [];
	
	protected function convertExceptionToArray($exception)
	{
		if ($exception instanceof UnprocessableEntityHttpException) {
			$errors = $exception->getErrors();
			return UnProcessibleHelper::assoc2indexed($errors);
		}
        if ($exception instanceof UnprocessibleEntityException) {
            /** @var ValidateErrorEntity[] $errors */
		    $errors = $exception->getErrorCollection();
		    $errorCollection = [];
            foreach ($errors as $error) {
                $errorCollection[] = [
                    'field' => $error->getField(),
                    'message' => $error->getMessage(),
                ];
            }
            return $errorCollection;
        }
		$this->runFilters($exception);
		return parent::convertExceptionToArray($exception);
	}

	protected function renderException($exception) {
        if ($exception instanceof UnprocessibleEntityException) {
            \Yii::$app->response->setStatusCode(HttpStatusCodeEnum::UNPROCESSABLE_ENTITY);
            \Yii::$app->response->data = $this->convertExceptionToArray($exception);
            \Yii::$app->response->send();
            return;
        }
        if ($exception instanceof NotFoundException) {
            \Yii::$app->response->setStatusCode(HttpStatusCodeEnum::NOT_FOUND);
            //\Yii::$app->response->data = $this->convertExceptionToArray($exception);
            \Yii::$app->response->send();
            return;
        }

        $this->runFilters($exception);
        parent::renderException($exception);
	}
	
	private function runFilters(\Throwable $exception) {
		$filterCollection = new ScenarioCollection($this->filters);
		$filterCollection->runAll($exception);
	}
	
}
