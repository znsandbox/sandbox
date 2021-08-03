<?php

namespace ZnSandbox\Sandbox\Rpc\Domain\Enums\Rbac;

use ZnCore\Base\Interfaces\GetLabelsInterface;

class RpcDocPermissionEnum implements GetLabelsInterface
{

    const ALL = 'oRbacDocAll';
    const ONE = 'oRbacDocOne';
    const DOWNLOAD = 'oRbacDocDownload';

    public static function getLabels()
    {
        return [
            self::ALL => 'Документация RPC. Просмотр списка',
            self::ONE => 'Документация RPC. Просмотр записи',
            self::DOWNLOAD => 'Документация RPC. Скачать',
        ];
    }
}
