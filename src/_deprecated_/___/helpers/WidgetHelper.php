<?php

namespace ZnLib\Web\Yii2\Widgets\helpers;

class WidgetHelper {

    public static function renderTemplateByRepo(RepoEntity $repoEntity, $name) {
        $url = self::renderTemplate($repoEntity->group->provider->url_templates[$name], $repoEntity->toArray());
        $url = $repoEntity->group->provider->host . '/' . $url;
        return $url;
    }
	
	
	public static function renderTemplate($template, $config) {
		$configPrepared = self::prepareTemplateConfig($config);
		$html = strtr($template, $configPrepared);
		return $html;
	}
	
	private static function prepareTemplateConfig($config) {
		$configPrepared = [];
		foreach($config as $key => $value) {
			$keyPrepared = '{' . $key . '}';
			$configPrepared[$keyPrepared] = $value;
		}
		return $configPrepared;
	}
}
