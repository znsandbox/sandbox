<?php

namespace ZnSandbox\Sandbox\RestClient\Yii\Web\models;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use yii\base\Model;

class IdentityForm extends Model
{

    public $login;
    public $password;

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => I18Next::t('restclient', 'identity.attributes.login'),
            'password' => I18Next::t('restclient', 'identity.attributes.password'),
        ];
    }

}