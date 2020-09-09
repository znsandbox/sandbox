<?php

namespace yii2rails\extension\menu\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii2rails\extension\common\helpers\Helper;
use yii2rails\extension\menu\interfaces\MenuInterface;
use yii2rails\extension\common\helpers\ModuleHelper;
use yii2rails\extension\common\helpers\UrlHelper;
use yii2rails\extension\yii\helpers\ArrayHelper;
use yii2rails\extension\web\enums\HtmlEnum;

//TODO [nkl90]: протестировать класс!
class MenuHelper
{

    const DIVIDER = 'DIVIDER_ELEMENT';
    const DIVIDER_HTML = '<li class="divider"></li>';

    public static function load($name, $key = null, $gen = false) {
        $menu = Helper::loadData($name, $key);
        if($gen) {
            $menu = MenuHelper::gen($menu);
        }
        return $menu;
    }

	public static function renderMenu($items, $glue = HtmlEnum::PIPE) {
        if(empty($items)) {
            return null;
        }
		$menuArr = [];
		foreach($items as $item) {
			$html = '';
			if(!empty($item['icon'])) {
				$html .= $item['icon'] . ' ';
			}
			$html .= Html::a($item['label'], $item['url']);
			$menuArr[] = $html;
		}
		return implode($glue, $menuArr);
	}
	
	public static function gen($items) {
		if(is_string($items)) {
			$items = self::runClass(['class' => $items]);
		}
		$result = [];
		if(empty($items)) {
		    return $result;
        }
		foreach($items as $index => $config) {
			$menu = self::genItem($config);
			if(!empty($menu)) {
				if(is_array($menu) && ArrayHelper::isIndexed($menu)) {
					$result = ArrayHelper::merge($result, $menu);
				} else {
					$result[] = $menu;
				}
			}
		}
        $result = self::trimDivider($result);
		return $result;
	}

    private static function trimDivider($items)
    {
        do {
            $item = ArrayHelper::getValue($items, '0');
            if($item == self::DIVIDER_HTML) {
                unset($items[0]);
                $items = array_values($items);
            }
        } while($item == self::DIVIDER_HTML);
        do {
            $index = count($items) - 1;
            $item = ArrayHelper::getValue($items, $index);
            if($item == self::DIVIDER_HTML) {
                unset($items[$index]);
                $items = array_values($items);
            }
        } while($item == self::DIVIDER_HTML);
        return $items;
    }

    private static function isDivider($menu)
    {
        return ArrayHelper::getValue($menu, 'options.class') == 'divider' || $menu == self::DIVIDER;
    }

    private static function isItem($menu)
    {
        $isItem = array_key_exists('items', $menu) || array_key_exists('url', $menu) || array_key_exists('js', $menu);
        return $isItem;
    }

    private static function isEmptyItem($menu)
    {
    	if(empty($menu)) {
    		return true;
	    }
    	$isItem = self::isItem($menu);
        $isEmpty = $isItem && empty($menu['items']) && empty($menu['url']) && empty($menu['js']);
        return $isEmpty;
    }

	private static function genItem($menu)
	{

        if(is_string($menu)) {
            if(self::isDivider($menu)) {
                return self::DIVIDER_HTML;
            } else {
                $menu = ['class' => $menu];
            }
        }

	    if(!empty($menu['class'])) {
			$menu = self::runClass($menu);
		}
		
		if(!empty($menu) && is_array($menu) && ArrayHelper::isIndexed($menu)) {
			$result = [];
			foreach($menu as $item) {
				$item = self::genItem($item);
				if(!empty($item)) {
					$result[] = $item;
				}
			}
			return array_values($result);
		}
		
		if(self::isEmptyItem($menu)) {
            return false;
        }

		if(self::isHidden($menu)) {
			return false;
		}
		$menu = self::translateLabel($menu);
		if(self::isHeader($menu)) {
			$menu['options'] = ['class' => 'header'];
			return $menu;
		}
		$menu = self::genChilds($menu);
		$menu['url'] = self::genUrl($menu);
		$menu['active'] = self::isActive($menu);
		$menu['icon'] = self::genIcon($menu);
		return $menu;
	}
	
	private static function runClass($menu) {
		if(empty($menu['class'])) {
			return $menu;
		}
		if(!class_exists($menu['class'])) {
			return null;
		}
		$menuEntity = Yii::createObject($menu);
        $result = false;
        if($menuEntity instanceof MenuInterface) {
			$result = $menuEntity->toArray();
		}
		return $result;
	}
	
	private static function genChilds($menu) {
		if(!empty($menu['items'])) {
			$menu['items'] = MenuHelper::gen($menu['items']);
			$menu['url'] = '#';
		}
		return $menu;
	}
	
	private static function genIcon($menu) {
		if(empty($menu['icon'])) {
			return null;
		}
		return '<i class="fa fa-' . $menu['icon'] . '"></i>';
	}
	
	private static function translateLabel($menu)
	{
	    if(empty($menu['label'])) {
	        return $menu;
        }
		$label = ArrayHelper::getValue($menu, 'label');
		if(is_array($label)) {
			$label = call_user_func_array('Yii::t', $label);
		}
        $menu['label'] = $label;
		return $menu;
	}
	
	private static function genUrl($menu)
	{
		if(!empty($menu['js'])) {
			return 'javascript: ' . $menu['js'];
		}
		if(isset($menu['url'])) {
			$url = is_array($menu['url']) ? $menu['url'][0] : $menu['url'];
		}else{
			$url = '';
		}
		if(!UrlHelper::isAbsolute($url)) {
			$url = SL . $url;
		}
		return $url;
	}
	
	private static function isHidden($menu) {
		
		return
			!self::isHasModule($menu) ||
			!self::isHasDomain($menu) ||
			!self::isAllow($menu) ||
			!empty($menu['hide']) ||
			(isset($menu['visible']) && empty($menu['visible']));
	}
	
	private static function isActiveChild($menu) {
		foreach($menu['items'] as $item) {
			if(!empty($item['active'])) {
				return true;
			}
		}
		return false;
	}
	
	private static function isHeader($menu) {
        return !self::isItem($menu) && !self::isDivider($menu);
	}
	
	private static function isActive($menu) {
		if(isset($menu['active'])) {
			return $menu['active'];
		}
		if(!empty($menu['items'])) {
			return self::isActiveChild($menu);
		}
		if(empty($menu['url'])) {
			return null;
		}
		if(APP == CONSOLE) {
			$currentUrl = '';
		} else {
			$currentUrl = Url::to();
		}
		$currentUrl = trim($currentUrl, SL);
		$url = $menu['url'];
		$url = trim($url, '/\\');
		$url = str_replace('\\', '/', $url);
		if(empty($url)) {
			return false;
		}
		return strpos($currentUrl, $url) !== false;
	}

	private static function isHasModule($menu) {

        if(empty($menu['module'])) {
			return true;
		}
        return ModuleHelper::has($menu['module']);
	}

	private static function isHasDomain($menu) {
		if(empty($menu['domain'])) {
			return true;
		}
		return \App::$domain->has($menu['domain']);
	}

	private static function isAllow($menu) {
		if(empty($menu['access'])) {
			return true;
		}
		$access = $menu['access'];
		$access = is_array($access) ? $access : [$access];
		$user = Yii::$app->user;
		foreach($access as $rule) {
			if($rule === '?') {
				if($user->getIsGuest()) {
                    return true;
                }
			} elseif($rule === '@') {
				if(!$user->getIsGuest()) {
                    return true;
                }
			} elseif($user->can($rule)) {
				return true;
			}
		}
		return false;
	}
	
}
