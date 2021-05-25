<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Enums\Rbac;

use ZnCore\Base\Interfaces\GetLabelsInterface;

class RbacAssignmentEnum implements GetLabelsInterface
{

    const ATTACH = 'oRbacAssignmentAttach';
    const DETACH = 'oRbacAssignmentDetach';

    public static function getLabels()
    {
        return [
            self::ATTACH => 'RBAC назначения полномочий. Прикрепить полномочие',
            self::DETACH => 'RBAC назначения полномочий. Открепить полномочие',
        ];
    }
}