<?php

namespace ZnSandbox\Sandbox\Apache\Domain\Repositories\Conf;

use ZnSandbox\Sandbox\Apache\Domain\Helpers\ConfParser;

class ServerRepository
{

    private $directory;

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    function all(): array {
        $commonTagCollection = ConfParser::readServerConfig($this->directory);
        $links = [];
        foreach ($commonTagCollection as $tagEntity) {
            if($tagEntity['tagName'] == 'VirtualHost' && !empty($tagEntity['config']['ServerName'])) {
                $hostName = $tagEntity['config']['ServerName'];
                $documentRoot = $tagEntity['config']['DocumentRoot'];
                $readmeMd = $documentRoot . '/README.md';
                if(file_exists($readmeMd)) {
                    $readmeMdLines = file($readmeMd);
                    $readmeMdTitle = ltrim($readmeMdLines[0], ' #');
                }
                $hostArray = explode('.', $hostName);
                $categoryName = \ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper::last($hostArray);
                $links[$categoryName]['title'] = $categoryName;
                $links[$categoryName]['items'][] = [
                    'url' => "{$hostName}",
                    'title' => $hostName . (isset($readmeMdTitle) ? "({$readmeMdTitle})" : ""),
                ];
            }
        }
        return $links;
    }
}
