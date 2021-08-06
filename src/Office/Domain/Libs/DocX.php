<?php

namespace ZnSandbox\Sandbox\Office\Domain\Libs;

use App\Common\Base\BaseController;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZipArchive;
use ZnCore\Base\Helpers\StringHelper;
use ZnCore\Base\Helpers\TemplateHelper;

class DocX
{

    private $zip;

    public function __construct(string $filename)
    {
        $this->zip = new Zip($filename);
    }

    public function replace(array $replacementList)
    {
        $document = $this->zip->readFile('word/document.xml');
        $document = TemplateHelper::render($document, $replacementList, '{{', '}}');
        $this->zip->writeFile('word/document.xml', $document);
    }

    public function close()
    {
        $this->zip->close();
    }
}
