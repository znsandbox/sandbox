<?php

namespace PhpLab\Sandbox\RestClient\Yii\Web\models;

use PhpLab\Core\Libs\I18Next\Facades\I18Next;
use yii\base\Model;

class ProjectForm extends Model
{

    public $name;
    public $title;
    //public $url;

    public function rules()
    {
        return [
            [['name', 'title'/*, 'url'*/], 'required'],
            //['url', 'url'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => I18Next::t('restclient', 'project.attributes.name'),
            'title' => I18Next::t('restclient', 'project.attributes.title'),
            //'url' => I18Next::t('restclient', 'project.attributes.url'),
        ];
    }

}