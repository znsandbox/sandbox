<?php

namespace PhpLab\Sandbox\RestClient\Yii\Web\models;

use PhpLab\Core\Libs\I18Next\Facades\I18Next;
use yii\base\Model;

class EnvironmentForm extends Model
{

    //public $id = null;
    public $project_id = null;
    public $isMain = false;
    public $title = null;
    public $url = null;

    public function rules()
    {
        return [
            [[/*'projectId',*/ 'title', 'url'], 'required'],
            ['url', 'url'],
            //['projectId', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
           // 'projectId' => I18Next::t('restclient', 'environment.attributes.projectId'),
            'title' => I18Next::t('restclient', 'environment.attributes.title'),
            'url' => I18Next::t('restclient', 'environment.attributes.url'),
        ];
    }

}