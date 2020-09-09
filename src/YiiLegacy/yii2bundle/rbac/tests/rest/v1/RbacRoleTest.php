<?php

namespace yii2bundle\rbac\tests\rest\v1;

use api\tests\functional\v1\article\ArticleSchema;
use yii2bundle\rbac\tests\rest\v1\RbacSchema;
use yii2tool\test\helpers\CurrentIdTestHelper;
use yii2tool\test\helpers\TestHelper;
use yii2tool\test\Test\BaseActiveApiTest;
use yii2bundle\account\domain\v3\helpers\test\AuthTestHelper;

class RbacRoleTest extends BaseActiveApiTest
{

    public $package = 'api';
    public $point = 'v1';
    public $resource = 'rbac-role';

    public function testAll()
    {
        AuthTestHelper::authByLogin('admin');
        $this->readCollection($this->resource, [], RbacSchema::$item, true);
    }

    public function testOne()
    {
        AuthTestHelper::authByLogin('admin');
        $this->readEntity($this->resource, 'rUser', RbacSchema::$item);
    }

    /*public function testRelation()
    {
        AuthTestHelper::authByLogin('admin');
        $this->assertRelationContract($this->resource, 'rUser', [
            'children' => [RbacSchema::$item],
        ]);
    }*/

}
