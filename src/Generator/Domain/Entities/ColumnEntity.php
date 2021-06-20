<?php

namespace ZnSandbox\Sandbox\Generator\Domain\Entities;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class ColumnEntity
{

    private $name;
    private $type;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }
}
