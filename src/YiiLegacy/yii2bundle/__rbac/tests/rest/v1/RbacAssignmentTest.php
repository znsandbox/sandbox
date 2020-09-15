<?php

namespace yii2bundle\rbac\tests\rest\v1;

use api\tests\functional\v1\article\ArticleSchema;
use yii2bundle\rbac\tests\rest\v1\RbacSchema;
use yii2tool\test\helpers\CurrentIdTestHelper;
use yii2tool\test\helpers\TestHelper;
use yii2tool\test\Test\BaseActiveApiTest;
use yii2bundle\account\domain\v3\helpers\test\AuthTestHelper;

class RbacAssignmentTest extends BaseActiveApiTest
{

    public $package = 'api';
    public $point = 'v1';
    public $resource = 'rbac-assignment';

    public function testAll()
    {
        AuthTestHelper::authByLogin('admin');
        $this->readCollection($this->resource, [], RbacSchema::$assignment, true);
    }

    public function testOne()
    {
        AuthTestHelper::authByLogin('admin');
        $this->readEntity($this->resource, '1_rAdministrator', RbacSchema::$assignment);
    }

}
