<?php

namespace ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets;

use yii\base\Widget;

class Alert extends Widget
{

    /**
     * information alert
     */
    const TYPE_INFO = 'alert-info';
    /**
     * danger/error alert
     */
    const TYPE_DANGER = 'alert-danger';
    /**
     * success alert
     */
    const TYPE_SUCCESS = 'alert-success';
    /**
     * warning alert
     */
    const TYPE_WARNING = 'alert-warning';
    /**
     * primary alert
     */
    const TYPE_PRIMARY = 'bg-primary';
    /**
     * default alert
     */
    const TYPE_DEFAULT = 'well';
    /**
     * custom alert
     */
    const TYPE_CUSTOM = 'alert-custom';

    public $collection = [];
	
	/**
	 * Runs the widget
	 */
	public function run()
	{
		$collection = $this->getCollection();
		$this->generateHtml($collection);
	}
	
	private function getCollection() {
		$collection = $this->collection;
		if(empty($collection)) {
			$collection = \App::$domain->navigation->alert->all();
		}
		if(empty($collection)) {
			$collection = [];
		}
		return $collection;
	}
	
	private function generateHtml($collection) {
		foreach($collection as $entity) {
		    $type = str_replace('alert-', '', $entity->type);
            $this->view->registerJs("toastr.{$type}('{$entity->content}'); \n");
		}
	}

}
