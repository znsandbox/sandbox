<?php

namespace yii2bundle\geo\domain\repositories\filedb;

use yii2rails\extension\filedb\repositories\base\BaseActiveFiledbRepository;
use yii2bundle\geo\domain\interfaces\repositories\PhoneInterface;

/**
 * Class PhoneRepository
 * 
 * @package yii2bundle\geo\domain\repositories\filedb
 * 
 * @property-read \yii2bundle\geo\domain\Domain $domain
 */
class PhoneRepository extends BaseActiveFiledbRepository implements PhoneInterface {

	protected $schemaClass = true;

}
