<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Helpers;

use ZnBundle\User\Domain\Enums\CredentialTypeEnum;

class UserFixtureHelper
{

    public static function generate($identityFixture, $credentialFixture): array
    {
        $identityFixture = \ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper::index($identityFixture, 'id');
        $collection = [];
        foreach ($credentialFixture as $credential) {
            if($credential['type'] == CredentialTypeEnum::LOGIN || $credential['type'] == CredentialTypeEnum::EMAIL) {
                $identity = $identityFixture[$credential['identity_id']];
                $collection[] = [
                    'login' => $identity['username'] ?? $credential['credential'],
                    'password' => 'Wwwqqq111',
                    'description' => null,
                ];
            }
        }
        return $collection;
    }
}