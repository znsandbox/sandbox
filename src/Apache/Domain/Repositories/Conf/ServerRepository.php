<?php

namespace ZnSandbox\Sandbox\Apache\Domain\Repositories\Conf;

use Illuminate\Support\Collection;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Libs\Query;
use ZnCrypt\Base\Domain\Enums\HashAlgoEnum;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Apache\Domain\Entities\ServerEntity;
use ZnSandbox\Sandbox\Apache\Domain\Helpers\ConfParser;

class ServerRepository
{

    private $directory;

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    public function oneByName(string $name)
    {
        $collection = $this->getIndexedCollection();
        if (!$collection->has($name)) {
            throw new NotFoundException('Server not found!');
        }
        return $collection->get($name);
    }

    /**
     * @return Collection | ServerEntity[]
     */
    private function getIndexedCollection(): Collection
    {
        $commonTagCollection = ConfParser::readServerConfig($this->directory);
        $commonTagCollection = ArrayHelper::index($commonTagCollection, 'config.ServerName');
        $collection = EntityHelper::createEntityCollection(ServerEntity::class, $commonTagCollection);
        return $collection;
    }

    function all(): array
    {
        $commonTagCollection = $this->getIndexedCollection();
        $links = [];
        foreach ($commonTagCollection as $tagEntity) {
            if ($tagEntity->getTagName() == 'VirtualHost' && !empty($tagEntity->getServerName())) {
                $hostName = $tagEntity->getServerName();
                $documentRoot = $tagEntity->getDocumentRoot();
                $hostArray = explode('.', $hostName);
                $categoryName = ArrayHelper::last($hostArray);
                $categoryHash = hash(HashAlgoEnum::CRC32B, $categoryName);

                $links[$categoryHash]['title'] = ($categoryName);
                $links[$categoryHash]['items'][] = [
                    'name' => $hostName,
                    'url' => "http://{$hostName}",
                    'title' => $hostName,
                    'description' => $this->getTitleFromReadme($documentRoot),
                    'category_name' => $categoryName,
                ];
            }
        }
        return $links;
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
