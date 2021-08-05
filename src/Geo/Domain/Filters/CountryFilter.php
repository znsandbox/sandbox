<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Filters;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Filter\DefaultSortInterface;

class CountryFilter implements DefaultSortInterface
{

    private $name;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

    }

    public function defaultSort(): array
    {
        return [];
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

}