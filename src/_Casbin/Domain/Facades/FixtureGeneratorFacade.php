<?php

namespace ZnUser\Rbac\Domain\Facades;

use ZnCore\Domain\Helpers\EntityHelper;
use ZnUser\Rbac\Domain\Libs\InheritanceMap;
use ZnUser\Rbac\Domain\Libs\MapItem;

class FixtureGeneratorFacade
{

    public static function generateInheritanceCollection(string $configFile): array
    {
        $inheritanceMap = new InheritanceMap($configFile);
        $mapItem = new MapItem($inheritanceMap);
        $result = $mapItem->run();
        $collection = [];
        foreach ($result['inheritance'] as $index => $entity) {
            $collection[] = EntityHelper::toArrayForTablize($entity);
        }
        return $collection;
    }

    public static function generateItemCollection(string $configFile): array
    {
        $inheritanceMap = new InheritanceMap($configFile);
        $mapItem = new MapItem($inheritanceMap);
        $result = $mapItem->run();
        $collection = [];
        foreach ($result['items'] as $index => $entity) {
            $collection[] = EntityHelper::toArrayForTablize($entity);
        }
        return $collection;
    }
}
