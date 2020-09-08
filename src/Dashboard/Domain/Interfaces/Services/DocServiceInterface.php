<?php

namespace ZnSandbox\Sandbox\Dashboard\Domain\Interfaces\Services;

use ZnCore\Base\Exceptions\NotFoundException;

interface DocServiceInterface
{

    /**
     * @param int $version
     * @return string
     * @throws NotFoundException
     */
    public function htmlByVersion(int $version): string;

    public function versionList(): array;

}

