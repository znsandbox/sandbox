<?php

namespace yii2bundle\rbac\domain\repositories\disc;

use yii2bundle\rbac\domain\helpers\DiscHelper;
use yii2bundle\rbac\domain\helpers\ItemHelper;
use yii2bundle\rbac\domain\interfaces\repositories\ItemInterface;
use yii2bundle\rbac\domain\repositories\base\BaseItemRepository;

/**
 * Class ItemRepository
 *
 * @package yii2bundle\rbac\domain\repositories\disc
 *
 * @property \yii2bundle\rbac\domain\Domain $domain
 */
class ItemRepository extends BaseItemRepository implements ItemInterface {
	
	protected function load()
	{
		$tree = DiscHelper::loadFromFile($this->itemFile);
		$time = @filemtime($this->itemFile);
		
		$this->items = ItemHelper::tree2items($tree, $time);
		$this->children = ItemHelper::tree2children($tree, $this->items);
	}
	
	protected function saveItems()
	{
		$items = ItemHelper::lists2tree($this->items, $this->children);
		DiscHelper::saveToFile($items, $this->itemFile);
		
		$this->domain->const->generateAll();
		
		//$this->domain->const->generateAll();
	}
	
}
