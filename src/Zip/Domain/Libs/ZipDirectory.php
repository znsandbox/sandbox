<?php

namespace ZnSandbox\Sandbox\Zip\Domain\Libs;

use Exception;
use ZipArchive;
use ZnCore\Base\Helpers\StringHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;

class ZipDirectory
{

    public function createZip(string $directory, string $zipFileName = 'arch.zip')
    {
        $files = FileHelper::scanDir($directory);
        $tmpDir = $this->getTmpDirectory();
        $zipFile = $tmpDir . '/' . $zipFileName;
        $zipArchive = $this->openZip($zipFile);
        foreach ($files as $fileName) {
            $zipArchive->addFile($directory . '/' . $fileName, $fileName);
        }
        $zipArchive->close();
        return $zipFile;
    }

    private function getTmpDirectory(): string
    {
        $tmpDir = sys_get_temp_dir() . '/' . StringHelper::genUuid();
        FileHelper::createDirectory($tmpDir);
        return $tmpDir;
    }

    private function openZip(string $zipFile): ZipArchive
    {
        $zipArchive = new ZipArchive();
        $resource = $zipArchive->open($zipFile, ZipArchive::CREATE);
        if ($resource !== TRUE) {
            throw new Exception('Zip not opened!');
        }
        return $zipArchive;
    }
}
