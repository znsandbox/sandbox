<?php

namespace yii2bundle\geo\domain\repositories\nationalbankKz;

use yii2bundle\geo\domain\entities\CurrencyValueEntity;
use yii2bundle\geo\domain\interfaces\repositories\CurrencyTransferInterface;
use yii2rails\domain\repositories\BaseRepository;
use yii2rails\extension\activeRecord\repositories\base\BaseActiveArRepository;

class CurrencyTransferRepository extends BaseRepository implements CurrencyTransferInterface {
	
	public function all() {
		$url = "http://www.nationalbank.kz/rss/rates.xml"; // Адрес до RSS-ленты
		$rss = simplexml_load_file($url);
		$data = json_decode(json_encode($rss), TRUE);
		$data = $data['channel']['item'];
		$collection = [];
		foreach ($data as $item) {
			$entity = new CurrencyValueEntity;
			$entity->code = $item['title'];
			$entity->value = $item['description'];
			$entity->publicated_at = $this->normalizeTime($item['pubDate']);
			$collection[] = $entity;
		}
		return $collection;
	}
	
	private function normalizeTime($pubDate) {
		$date = explode(DOT, $pubDate);
		$date = array_reverse($date);
		if(strlen($date[0]) == 2) {
			$date[0] = '20' . $date[0];
		}
		$dateStr = implode('-', $date) . ' 00:00:00';
		return $dateStr;
	}
	
}
