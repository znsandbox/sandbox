<?php

namespace ZnSandbox\Sandbox\Office\Domain\Libs;

use App\Common\Base\BaseController;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZipArchive;
use ZnCore\Base\Helpers\StringHelper;

class Zip
{

    private $resource;
    private $zipArchive;

    public function __construct(string $zipFile)
    {
        $this->zipArchive = new ZipArchive();
        $this->resource = $this->zipArchive->open($zipFile, ZipArchive::CREATE);
        if ($this->resource === TRUE) {

        } else {
            throw new Exception('Zip not opened!');
        }
    }

    public function getDirectoryFiles(string $directory) {
        $props = [];
        $fileList = $this->files();
        foreach ($fileList as $file) {
            $isMatch = fnmatch($directory . '/*', $file);
            if($isMatch) {
                $name = str_replace($directory . '/', '', $file);
                $props[$name] = $this->readFile($file);
            }
        }
        return $props;
    }

    public function files()
    {
        $i = 0;
        $list = array();
        while($name = $this->zipArchive->getNameIndex($i)) {
            $list[$i] = $name;
            $i++;
        }
        return $list;
    }

    public function readFile($name)
    {
        return $this->zipArchive->getFromName($name);
    }

    public function writeFile($name, $content)
    {
        return $this->zipArchive->addFromString($name, $content);
    }

    public function close()
    {
        $this->zipArchive->close();
    }
}
