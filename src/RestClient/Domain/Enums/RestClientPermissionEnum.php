<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Enums;

use ZnCore\Domain\Base\BaseEnum;

class RestClientPermissionEnum extends BaseEnum
{

    const PROJECT_WRITE = 'oRestClientProjectWrite';
    const PROJECT_READ = 'oRestClientProjectRead';
    const PROJECT_MANAGE = 'oRestClientProjectManage';
    const ACCESS_MANAGE = 'oRestClientAccessManage';

    /** @deprecated */
    const CLIENT_ALL = 'oRestClientAll';

    public static function getLabels() {
        return [
            self::PROJECT_WRITE => 'REST-клиент. Модификация проекта',
            self::PROJECT_READ => 'REST-клиент. Чтение проекта',
            self::PROJECT_MANAGE => 'REST-клиент. Управление проектом',
            self::ACCESS_MANAGE => 'REST-клиент. Управление доступами к проектам',
            self::CLIENT_ALL => 'Доступ к REST-клиенту',
        ];
    }

}
