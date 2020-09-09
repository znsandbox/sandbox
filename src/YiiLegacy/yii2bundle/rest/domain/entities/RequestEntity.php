<?php

namespace yii2bundle\rest\domain\entities;

use yii2rails\domain\BaseEntity;
use yii2rails\extension\web\enums\HttpMethodEnum;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

/**
 * Class RequestEntity
 * @package yii2rails\domain\entities
 *
 * @property $method string
 * @property $uri string
 * @property $baseUrl string
 * @property $data array
 * @property $headers array
 * @property $files array
 * @property $options array
 * @property $cookies array
 * @property $format string
 * @property-read $post array
 * @property-read $query array
 * @property $description string
 * @property $authorization string
 */
class RequestEntity extends BaseEntity {

	protected $method = HttpMethodEnum::GET;
    protected $baseUrl;
	protected $uri;
	protected $data = [];
	protected $headers = [];
    protected $files = [];
	protected $options = [];
	protected $cookies = [];
	protected $format = null;
	protected $description = null;
	protected $authorization = null;
	
	public function rules() {
		return [
			[['uri'], 'required'],
			[['method'], 'in', 'range' => HttpMethodEnum::values()],
		];
	}
	
	public function getMethod() {
		return strtoupper($this->method);
	}
	
	public function getPost() {
		return $this->data;
	}
	
	public function getQuery() {
		return $this->data;
	}

    public function setHeaders($value) {
        if($value) {
            $headers = [];
            foreach ($value as $key => $value) {
                if(is_array($value)) {
                    $headers[$key] = ArrayHelper::first($value);
                } else {
                    $headers[$key] = $value;
                }
            }
            $this->headers = $headers;
        }
    }
}