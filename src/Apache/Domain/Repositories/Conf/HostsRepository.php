<?php

namespace ZnSandbox\Sandbox\Apache\Domain\Repositories\Conf;

use Illuminate\Support\Collection;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\FileSystem\Helpers\FileStorageHelper;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;
use ZnSandbox\Sandbox\Apache\Domain\Entities\HostEntity;
use ZnSandbox\Sandbox\Apache\Domain\Entities\HostGroupEntity;
use ZnSandbox\Sandbox\Apache\Domain\Entities\ServerEntity;
use ZnSandbox\Sandbox\Apache\Domain\Helpers\ConfParser;
use ZnSandbox\Sandbox\Apache\Domain\Helpers\HostsParser;

class HostsRepository
{

    private static $collection = null;

    public function oneByName(string $name)
    {
        $collection = $this->getIndexedCollection();
        if (!$collection->has($name)) {
            throw new NotFoundException('Host not found!');
        }
        return $collection->get($name);
    }

    /**
     * @return Collection | ServerEntity[]
     */
    private function getIndexedCollection(): Collection
    {
        if(self::$collection == null) {
            $hostsContent = FileStorageHelper::load('/etc/hosts');
            preg_match_all("/#\s*<([a-zA-Z_-]+)([^>]*)>([\s\S]+?)#\s*<\/([a-zA-Z_-]+)>/i", $hostsContent, $matches);
            $collection = [];
            $all = [];
            foreach ($matches[0] as $index => $value) {
                $item = [];
                $item['tagName'] = $matches[1][$index];
                $hostsCollection = HostsParser::parse($matches[3][$index]);
                foreach ($hostsCollection as &$host) {
                    $host['categoryName'] = $item['tagName'];
                    $collection[$host['host']] = $host;
                }
            }
            self::$collection = EntityHelper::createEntityCollection(HostEntity::class, $collection);
        }
        return self::$collection;
    }

    function all(): Collection
    {
        $commonTagCollection = $this->getIndexedCollection();
        return $commonTagCollection;
    }

    private function getTitleFromReadme(string $documentRoot): string
    {
        $readmeMd = $documentRoot . '/README.md';
        $readmeMdTitle = '';
        if (file_exists($readmeMd)) {
            $readmeMdLines = file($readmeMd);
            $readmeMdTitle = ltrim($readmeMdLines[0], ' #');
            $readmeMdTitle = trim($readmeMdTitle);
        }
        return $readmeMdTitle;
    }

}
