<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Enums\Rbac;

use ZnCore\Base\Interfaces\GetLabelsInterface;
use ZnCore\Contract\Rbac\Interfaces\GetRbacInheritanceInterface;

class BlockchainDocumentPermissionEnum implements GetLabelsInterface, GetRbacInheritanceInterface
{

    public const CRUD = 'oBlockchainDocumentCrud';

    public const ALL = 'oBlockchainDocumentAll';

    public const ONE = 'oBlockchainDocumentOne';

    public const CREATE = 'oBlockchainDocumentCreate';

    public const UPDATE = 'oBlockchainDocumentUpdate';

    public const DELETE = 'oBlockchainDocumentDelete';

    public const RESTORE = 'oBlockchainDocumentRestore';

    public static function getLabels()
    {
        return [
            self::CRUD => 'BlockchainDocument. Полный доступ',
            self::ALL => 'BlockchainDocument. Просмотр списка',
            self::ONE => 'BlockchainDocument. Просмотр записи',
            self::CREATE => 'BlockchainDocument. Создание',
            self::UPDATE => 'BlockchainDocument. Редактирование',
            self::DELETE => 'BlockchainDocument. Удаление',
            self::RESTORE => 'BlockchainDocument. Восстановление',
        ];
    }

    public static function getInheritance()
    {
        return [
            self::CRUD => [
                self::ALL,
                self::ONE,
                self::CREATE,
                self::UPDATE,
                self::DELETE,
                self::RESTORE,
            ],
        ];
    }


}

