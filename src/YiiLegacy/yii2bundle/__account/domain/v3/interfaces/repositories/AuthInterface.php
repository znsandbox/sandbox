<?php

namespace yii2bundle\account\domain\v3\interfaces\repositories;

use ZnBundle\User\Yii\Entities\LoginEntity;

interface AuthInterface {
	
	/**
	 * @param string $login
	 * @param string $password
	 * @param null   $ip
	 *
	 * @return LoginEntity
	 */
	public function authentication($login, $password, $ip = null);

    //public function authenticationByToken($token/*, $type = null, $ip = null*/);
}