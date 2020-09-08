<?php

namespace ZnSandbox\Sandbox\Dashboard\Domain\Services;

use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Helpers\StringHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnSandbox\Sandbox\Dashboard\Domain\Interfaces\Services\DocServiceInterface;

class DocService implements DocServiceInterface
{

    private $docFileNameMask;
    private $docDirectory;

    public function __construct(string $docFileNameMask = 'v{version}.html', string $docDirectory = 'docs/api/dist')
    {
        $this->docFileNameMask = $docFileNameMask;
        $this->docDirectory = $docDirectory;
    }

    public function versionList(): array {
        $list = FileHelper::scanDir(FileHelper::rootPath() . '/' . $this->docDirectory);
        $pattern = $this->generateRegExp($this->docFileNameMask);
        $result = [];
        foreach ($list as $fileName) {
            if(preg_match($pattern, $fileName, $matches)) {
                $version = $matches[1];
                $result[] = $version;
            }
        }
        return $result;
    }

    public function htmlByVersion(int $version): string {
        $fileName = StringHelper::renderTemplate($this->docFileNameMask, ['version' => $version]);
        $docFileName = FileHelper::path($this->docDirectory . '/' . $fileName);
        $htmlContent = @file_get_contents($docFileName);
        if(empty($htmlContent)) {
            throw new NotFoundException("Not found API documentation for version v{$version}!");
        }
        return $htmlContent;
    }

    private function generateRegExp($docFileNameMask) {
        $pattern = preg_quote($docFileNameMask);
        $pattern = str_replace('\{version\}', '(\d+)', $pattern);
        $pattern = '/' . $pattern . '/i';
        return $pattern;
    }

}
