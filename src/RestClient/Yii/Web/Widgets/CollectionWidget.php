<?php

namespace PhpLab\Sandbox\RestClient\Yii\Web\Widgets;

use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use Yii;
use yii\base\Widget;

class CollectionWidget extends Widget
{

    public $projectId;
    public $tag;
    public $type;

    /** @var BookmarkServiceInterface */
    protected $bookmarkService;
    /** @var ProjectServiceInterface */
    protected $projectService;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->bookmarkService = Yii::$container->get(BookmarkServiceInterface::class);
        $this->projectService = Yii::$container->get(ProjectServiceInterface::class);
    }

    public function run()
    {
        $projectEntity = $this->projectService->oneById($this->projectId);
        $collection = $this->bookmarkService->allFavoriteByProject($this->projectId);
        $history = $this->bookmarkService->allHistoryByProject($this->projectId);
        return $this->renderFile(__DIR__ . '/../views/request/collection/index.php', [
            'collection' => $collection,
            'tag' => $this->tag,
            'history' => $history,
            'projectEntity' => $projectEntity,
        ]);
    }

}
