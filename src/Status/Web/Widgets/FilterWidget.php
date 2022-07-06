<?php

namespace ZnSandbox\Sandbox\Status\Web\Widgets;

use Symfony\Component\HttpFoundation\Request;
use ZnCore\Base\Enum\Helpers\EnumHelper;
use ZnCore\Validation\Interfaces\ValidationByMetadataInterface;
use ZnCore\Collection\Interfaces\Enumerable;
use ZnCore\Entity\Helpers\CollectionHelper;
use ZnCore\Entity\Helpers\EntityHelper;
use ZnLib\Web\Html\Helpers\Html;
use ZnLib\Web\Widget\Base\BaseWidget2;
use ZnSandbox\Sandbox\Status\Domain\Entities\EnumEntity;

class FilterWidget extends BaseWidget2
{

    private $layoutTagName = 'ul';
    private $layoutTagOptions = [
        'class' => 'nav nav-pills',
    ];
    private $itemTagName = 'li';
    private $itemTagOptions = [
        'class' => 'nav-item',
    ];
    private $itemTagLinkOptions = [
        'class' => 'nav-link',
    ];
    private $filterQuery = 'filter';
    private $filterParamName = 'status_id';
    private $request;
    private $filterModel;
    private $enumClass;

    public function __construct(string $enumClass, ValidationByMetadataInterface $filterModel, Request $request = null)
    {
        $this->request = Request::createFromGlobals();
        $this->enumClass = $enumClass;
        $this->filterModel = $filterModel;
    }

    public function run(): string
    {
        $itemsHtml = $this->renderItems();
        return $this->renderLayout($itemsHtml);
    }

    private function generateUrl(EnumEntity $enumEntity)
    {
        $params = $this->request->query->all();
        if (isset($params['page'])) {
            unset($params['page']);
        }
        $params[$this->filterQuery][$this->filterParamName] = $enumEntity->getId();
        $queryString = http_build_query($params);
        return '?' . $queryString;
    }

    private function generateItem(EnumEntity $enumEntity)
    {
        $enumId = EntityHelper::getAttribute($this->filterModel, $this->filterParamName);
        $uri = $this->generateUrl($enumEntity);
        $activeClass = $enumId == $enumEntity->getId() ? 'active' : '';
        $itemLinkOptions = $this->itemTagLinkOptions;
        $itemLinkOptions['class'] = $itemLinkOptions['class'] . ' ' . $activeClass;
        $itemLinkOptions['href'] = $uri;
        $link = Html::tag('a', $enumEntity->getTitle(), $itemLinkOptions);
        return Html::tag($this->itemTagName, $link, $this->itemTagOptions);
    }

    private function getItemCollection(): Enumerable
    {
        /** @var EnumEntity[] | Enumerable $collection */
        $items = EnumHelper::getItems($this->enumClass);
        $collection = CollectionHelper::create(EnumEntity::class, $items);
        return $collection;
    }

    private function renderItems()
    {
        $collection = $this->getItemCollection();
        $itemsHtml = '';
        foreach ($collection as $enumEntity) {
            $itemsHtml .= $this->generateItem($enumEntity);
        }
        return $itemsHtml;
    }

    private function renderLayout(string $items)
    {
        return Html::tag($this->layoutTagName, $items, $this->layoutTagOptions);
    }
}
