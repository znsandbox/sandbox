<?php

namespace yii2bundle\rest\domain\rest;

use Yii;
use yii\base\Arrayable;
use yii\data\BaseDataProvider;
use yii\data\DataProviderInterface;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii2rails\extension\develop\helpers\Debug;
use yii2rails\extension\common\helpers\TypeHelper;
use yii\rest\Serializer as YiiSerializer;
use yii2rails\extension\web\enums\HttpHeaderEnum;

class Serializer extends YiiSerializer {
	
	public $format = [];
	
	public $offsetHeader = 'X-Pagination-Offset';
	
	protected function serializeModel($model) {
		$item = parent::serializeModel($model);
		if(!empty($item)) {
			$item = TypeHelper::serialize($model, $this->format);
		}
		return $item;
	}
	
	protected function serializeModels(array $models) {
        $models = TypeHelper::serializeModels($models, $this->format);
		return $models;
	}

	private function addRuntimeHeader() {
		if(!YII_ENV_DEV) {
			return;
		}
		$runtime = Debug::getRuntime();
		$headers = $this->response->getHeaders();
		$headers->set(HttpHeaderEnum::X_RUNTIME, $runtime . ' s');
	}
	
	public function serialize($data) {
		$this->addRuntimeHeader();
        $serializedData = parent::serialize($data);
        list($fields, $expand) = $this->getRequestedFields();
        if($fields) {
            $fields = ArrayHelper::merge($fields, $expand);
            $fields = array_unique($fields);
            $fields = array_values($fields);
            if ($data instanceof Arrayable) {
                $serializedData = ArrayHelper::filter($serializedData, $fields);
            } elseif ($data instanceof DataProviderInterface) {
                foreach ($serializedData as &$item) {
                    $item = ArrayHelper::filter($item, $fields);
                }
            }
        }
        return $serializedData;
	}
	
	protected function addPaginationHeaders($pagination)
	{
		$headers = $this->response->getHeaders();
		/** @var Pagination $pagination */
		$headers->set($this->totalCountHeader, $pagination->totalCount);
		$headers->set($this->pageCountHeader, $pagination->getPageCount());
		$headers->set($this->perPageHeader, $pagination->pageSize);
		$offset = Yii::$app->request->get('offset');
		if($offset !== null) {
			$offset = $offset < $pagination->totalCount ? $offset : $pagination->totalCount;
			$offset = intval($offset);
			$headers->set($this->offsetHeader, $offset);
		} else {
			$headers->set($this->currentPageHeader, $pagination->getPage() + 1);
			$headers->set($this->offsetHeader, $pagination->getOffset());
			$headers->set('Link', $this->generateLinks($pagination));
		}
	}
	
	private function generateLinks(Pagination $pagination) {
		$links = [];
		foreach ($pagination->getLinks(true) as $rel => $url) {
			$links[] = "<$url>; rel=$rel";
		}
		return implode(', ', $links);
	}
}
