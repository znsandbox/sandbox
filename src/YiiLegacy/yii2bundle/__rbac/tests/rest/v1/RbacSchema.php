<?php

namespace yii2bundle\rbac\tests\rest\v1;

use yii2tool\test\enums\TypeEnum;

class RbacSchema
{

    public static $item = [
        'name' => TypeEnum::STRING,
        'description' => TypeEnum::STRING,
        'rule_name' => [TypeEnum::STRING, TypeEnum::NULL],
        'data' => [TypeEnum::ARRAY, TypeEnum::NULL],
    ];

    public static $assignment = [
        'id' => TypeEnum::STRING,
        'user_id' => TypeEnum::INTEGER,
        'item_name' => TypeEnum::STRING,
    ];

}
