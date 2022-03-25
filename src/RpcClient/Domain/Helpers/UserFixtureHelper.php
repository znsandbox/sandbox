<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Helpers;

use ZnBundle\User\Domain\Enums\CredentialTypeEnum;

class UserFixtureHelper
{

    public static function generate($identityCollection, $credentialCollection): array
    {
        $identityCollection = \ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper::index($identityCollection, 'id');
        $collection = [];
        foreach ($credentialCollection as $credential) {
            if (in_array($credential['type'], [CredentialTypeEnum::LOGIN, CredentialTypeEnum::EMAIL])) {
                $identity = $identityCollection[$credential['identity_id']];
                $collection[] = [
                    'login' => $credential['credential'],
                    'password' => 'Wwwqqq111',
                    'description' => $identity['username'] ?? null,
                ];
            }
        }
        return $collection;
    }
}