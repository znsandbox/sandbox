<?php

namespace ZnSandbox\Sandbox\Layout\Domain\Services;

use Illuminate\Support\Collection;
use Yii;
use yii\helpers\Url;
use ZnBundle\User\Domain\Exceptions\UnauthorizedException;
use ZnCore\Base\Exceptions\ForbiddenException;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Legacy\Yii\Helpers\Inflector;
use ZnCore\Base\Libs\I18Next\Exceptions\NotFoundBundleException;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Libs\Query;
use ZnLib\Web\Widgets\Interfaces\MenuInterface;
use ZnSandbox\Sandbox\Layout\Domain\Entities\MenuEntity;
use ZnSandbox\Sandbox\Layout\Domain\Interfaces\Repositories\MenuRepositoryInterface;
use ZnSandbox\Sandbox\Layout\Domain\Interfaces\Services\MenuServiceInterface;
use ZnUser\Rbac\Domain\Interfaces\Services\ManagerServiceInterface;

class MenuService extends BaseCrudService implements MenuServiceInterface
{

    private $managerService;

    public function __construct(MenuRepositoryInterface $repository, ManagerServiceInterface $managerService)
    {
        $this->setRepository($repository);
        $this->managerService = $managerService;
    }

    public function allByFileName(string $fileName): Collection
    {
        $this->getRepository()->setFileName($fileName);
        return $this->all();
    }

    public function all(Query $query = null)
    {
        /** @var MenuEntity[] $collection */
        $collection = parent::all($query);
        foreach ($collection as $menuEntity) {
            $this->prepareEntity($menuEntity);
        }
        return $collection;
    }

    private function getRoute(): string
    {
        $action = Yii::$app->requestedAction;
        $route = $action->controller->module->id . '/' . $action->controller->id;
        return $route;
    }

    private function prepareEntity(MenuEntity $menuEntity)
    {
        if ($menuEntity->getWidget()) {
            /** @var MenuInterface $widgetInstance */
            $widgetInstance = ClassHelper::createObject($menuEntity->getWidget());
            $item = $widgetInstance->menu();
            EntityHelper::setAttributes($menuEntity, $item);
        }

        if ($menuEntity->getModule()) {
            if(class_exists(Yii::class)) {
                $isVisible = array_key_exists($menuEntity->getModule(), Yii::$app->modules);
            } else {
                $isVisible = true;
            }
            $menuEntity->setVisible($isVisible);
            if (!$isVisible) {
                return;
            }
        }

        if ($menuEntity->getRoute()) {
            if ($menuEntity->getLabel() === null && $menuEntity->getLabelTranslate() == null) {
                $this->prepareLabelForRoute($menuEntity);
            }
            if ($menuEntity->getActive() === null) {
                $menuEntity->setActive($this->getRoute() == $menuEntity->getRoute());
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
            $active = in_array($this->getRoute(), $menuEntity->getActiveRoutes());
            $menuEntity->setActive($active);
        }
        if ($menuEntity->getUrl() == null) {
            $menuEntity->addOption('class', 'nav-header');
        }
        if($menuEntity->getItems()) {
            $isVisibleItems = false;
            foreach ($menuEntity->getItems() as $itemMenuEntity) {
                $this->prepareEntity($itemMenuEntity);
                if($itemMenuEntity->getVisible()) {
                    $isVisibleItems = true;
                }
            }
            $menuEntity->setVisible($isVisibleItems);
        }
        /*if($menuEntity->getUrl() == null) {
            foreach ($menuEntity->getItems() as $subMenuEntity) {

            }
            $menuEntity->setVisible(false);
        }*/
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
        try {
            $this->managerService->checkMyAccess($menuEntity->getAccess());
            $menuEntity->setVisible(true);
        } catch (ForbiddenException|UnauthorizedException $e) {
            $menuEntity->setVisible(false);
        }

        /*foreach ($menuEntity->getAccess() as $accessItem) {

            if(class_exists(Yii::class)) {
                if (Yii::$app->authManager->checkAccess(Yii::$app->user->id, $accessItem)) {
                    $menuEntity->setVisible(true);
                    break;
                }
            } else {
                $menuEntity->setVisible(true);
            }
        }*/
    }
}
