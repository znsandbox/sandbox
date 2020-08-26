<?php

namespace PhpLab\Sandbox\Dashboard\Domain\Interfaces\Services;

use PhpLab\Core\Exceptions\NotFoundException;

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

