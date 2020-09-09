<?php

namespace yii2rails\extension\store;

use yii2rails\extension\store\interfaces\DriverInterface;
use yii2rails\extension\yii\helpers\FileHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use yii\base\Component;

class Store extends Component
{

    protected $driver;

    /**
     * @var DriverInterface
     */
    protected $driverInstance;

    public function setDriver($driver) {
		$driver = strtolower($driver);
		$driver = ucfirst($driver);
        $this->driver = $driver;
        $driverClass = 'yii2rails\extension\store\drivers\\' . $driver;
        $implements = class_implements($driverClass);
        if(!array_key_exists('yii2rails\extension\store\interfaces\DriverInterface', $implements)) {
            throw new \Exception('No implements interface of driver class');
        }
        $this->driverInstance = new $driverClass;
    }

    public function getDriver() {
        return strtolower($this->driver);
    }

    public function __construct($driver) {
        $this->setDriver($driver);
    }

    public function decode($content, $key = null) {
        $data = $this->driverInstance->decode($content);
        if(empty($data)) {
            $data = [];
        }
        if(func_num_args() > 1) {
            return ArrayHelper::getValue($data, $key);
        }
        return $data;
    }

    public function encode($data) {
        return $this->driverInstance->encode($data);
    }

    public function update($fileAlias, $key, $value) {
        $data = $this->load($fileAlias);
        ArrayHelper::set($data, $key, $value);
        $this->save($fileAlias, $data);
    }

    public function load($fileAlias, $key = null) {
        $fileName = FileHelper::getAlias($fileAlias);
		if(!FileHelper::has($fileName)) {
			return null;
		}
		if(method_exists($this->driverInstance, 'load')) {
			if(func_num_args() > 1) {
				return $this->driverInstance->load($fileName, $key);
			}
			return $this->driverInstance->load($fileName);
		}
        $content = FileHelper::load($fileName);
        if(func_num_args() > 1) {
            return $this->decode($content, $key);
        }
        return $this->decode($content);
    }

    public function save($fileAlias, $data) {
        $fileName = FileHelper::getAlias($fileAlias);
		if(method_exists($this->driverInstance, 'save')) {
			return $this->driverInstance->save($fileName, $data);
		}
		$content = $this->encode($data);
        FileHelper::save($fileName, $content);
    }

}