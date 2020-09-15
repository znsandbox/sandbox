<?php

namespace yii2bundle\account\domain\v3\strategies\token\handlers;

use ZnCrypt\Jwt\Domain\Entities\JwtEntity;
use ZnCrypt\Jwt\Domain\Interfaces\Services\JwtServiceInterface;
use ZnCrypt\Jwt\Domain\Repositories\Config\ProfileRepository;
use ZnCrypt\Jwt\Domain\Services\JwtService;
use yii\web\UnauthorizedHttpException;
use yii2bundle\account\domain\v3\dto\TokenDto;
use ZnBundle\User\Yii\Entities\LoginEntity;
use yii2rails\domain\data\Query;

class JwtStrategy implements HandlerInterface {
	
	public $profile;
	
	public function getIdentityId(TokenDto $tokenDto) {

        $jwtService = $this->createJwtService();
        $jwtService->verify($tokenDto->token, $this->profile);
        $jwtEntity = $jwtService->decode($tokenDto->token, $this->profile);
		return $jwtEntity->payload->subject->id;
	}
	
	public function forge($userId, $ip, $profile = null) {
		$subject = [
			'id' => $userId,
		];

        $jwtEntity = new JwtEntity;
        $jwtEntity->subject = $subject;
        $profile = $profile ? $profile : $this->profile;
        $jwtService = $this->createJwtService();
        $tokenString = $jwtService->sign($jwtEntity, $profile);



        $jwtEntity = $jwtService->decode($tokenString, $this->profile);

        //dd($jwtEntity);

		return 'jwt '  . $tokenString;
	}

    private function buildToken(LoginEntity $loginEntity): string {
        $jwtEntity = new JwtEntity;
        $jwtEntity->subject = $loginEntity->id;
        $jwtService = $this->createJwtService();
        $tokenString = $jwtService->sign($jwtEntity, 'auth');
        return $tokenString;
    }

    private function createJwtService(): JwtServiceInterface {
        $profileRepo = new ProfileRepository;
        $jwtService = new JwtService($profileRepo);
        return $jwtService;
    }
}
