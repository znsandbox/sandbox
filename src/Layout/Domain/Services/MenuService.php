<?php

namespace ZnSandbox\Sandbox\Layout\Domain\Services;

use Illuminate\Support\Collection;
use ZnSandbox\Sandbox\Layout\Domain\Entities\MenuEntity;
use ZnSandbox\Sandbox\Layout\Domain\Interfaces\Repositories\MenuRepositoryInterface;
use ZnSandbox\Sandbox\Layout\Domain\Interfaces\Services\MenuServiceInterface;
use Yii;
use yii\helpers\Url;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Legacy\Yii\Helpers\Inflector;
use ZnCore\Base\Libs\I18Next\Exceptions\NotFoundBundleException;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Libs\Query;
use ZnLib\Web\Widgets\Interfaces\MenuInterface;

class MenuService extends BaseCrudService implements MenuServiceInterface
{

    public function __construct(MenuRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }

    public function allByFileName(string $fileName): Collection
    {
        $this->getRepository()->setFileName($fileName);
        return $this->all();
    }

    public function all(Query $query = null)
    {
        $action = Yii::$app->requestedAction;
        $route = $action->controller->module->id . '/' . $action->controller->id;

        /** @var MenuEntity[] $collection */
        $collection = parent::all($query);
        foreach ($collection as $menuEntity) {
            $this->prepareEntity($menuEntity, $route);
        }
        return $collection;
    }

    private function prepareEntity(MenuEntity $menuEntity, string $route)
    {

        if ($menuEntity->getWidget()) {
            /** @var MenuInterface $widgetInstance */
            $widgetInstance = ClassHelper::createObject($menuEntity->getWidget());
            $item = $widgetInstance->menu();
            EntityHelper::setAttributes($menuEntity, $item);
        }

        if ($menuEntity->getModule()) {
            $isVisible = array_key_exists($menuEntity->getModule(), Yii::$app->modules);
            $menuEntity->setVisible($isVisible);
            if (!$isVisible) {
                return;
            }
        }

        if ($menuEntity->getRoute()) {
            if ($menuEntity->getLabel() === null) {
                $this->prepareLabelForRoute($menuEntity);
            }
            if($menuEntity->getActive() === null) {
                $menuEntity->setActive($route == $menuEntity->getRoute());
            }
            if ($menuEntity->getUrl() === null) {
                $menuEntity->setUrl(Url::to(['/' . $menuEntity->getRoute()]));
            }
        }
        if ($menuEntity->getAccess()) {
            $this->prepareAccess($menuEntity);
        }
        if ($menuEntity->getLabel() == null && $menuEntity->getLabelTranslate() != null) {
            $this->prepareLabelForTranslate($menuEntity);
        }
        if ($menuEntity->getActiveRoutes()) {
            $active = in_array($route, $menuEntity->getActiveRoutes());
            $menuEntity->setActive($active);
        }
        if ($menuEntity->getUrl() == null) {
            $menuEntity->addOption('class', 'nav-header');
        }
        /*if(is_array($menuEntity->getLabel())) {
            $menuEntity->setLabel(I18Next::translateFromArray($menuEntity->getLabel()));
        }*/
    }

    private function prepareLabelForTranslate(MenuEntity $menuEntity)
    {
        $labelTranslate = $menuEntity->getLabelTranslate();
        try {
            $label = I18Next::t($labelTranslate[0], $labelTranslate[1]);
        } catch (NotFoundBundleException $e) {
            $label = "{$labelTranslate[0]}.{$labelTranslate[1]}";
        }
        $menuEntity->setLabel($label);
    }

    private function prepareLabelForRoute(MenuEntity $menuEntity)
    {
        $key = $menuEntity->getController() . '.title';
        try {
            $label = I18Next::t($menuEntity->getModule(), $key);
            if ($label == $key) {
                throw new NotFoundBundleException();
            }
        } catch (NotFoundBundleException $e) {
            $label = $menuEntity->getModule() . ' ' . $menuEntity->getController();
            $label = Inflector::titleize($label);
        }
        $menuEntity->setLabel($label);
    }

    private function prepareAccess(MenuEntity $menuEntity)
    {
        $menuEntity->setVisible(false);
        foreach ($menuEntity->getAccess() as $accessItem) {
            if (Yii::$app->authManager->checkAccess(Yii::$app->user->id, $accessItem)) {
                $menuEntity->setVisible(true);
                break;
            }
        }
    }
}
