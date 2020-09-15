<?php

namespace tests\functional\v3\services;

use yii2tool\test\Test\Unit;
use Yii;
use ZnBundle\User\Yii\Entities\LoginEntity;
use tests\functional\v3\enums\LoginEnum;

class SecurityTest extends Unit
{
	
	public function testOneByIdentityId()
	{
		/** @var LoginEntity $entity */
		$entity = \App::$domain->account->security->oneByIdentityId(LoginEnum::ID_ADMIN);
		$this->tester->assertEntity([
			'identity_id' => LoginEnum::ID_ADMIN,
			'password_hash' => LoginEnum::PASSWORD_HASH,
		], $entity);
	}
	
}
