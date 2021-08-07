<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Facades;

use ZnCore\Domain\Helpers\EntityHelper;
use ZnSandbox\Sandbox\Casbin\Domain\Libs\InheritanceMap;
use ZnSandbox\Sandbox\Casbin\Domain\Libs\MapItem;

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
