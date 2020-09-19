<?php

namespace ZnSandbox\Sandbox\Bot\Domain\Helpers;

class MlHelper
{

    static public function prepareWord($line)
    {
        $line = \ZnCore\Base\Helpers\StringHelper::filterChar($line, '#[^а-яА-ЯёЁa-zA-Z\s]+#u');
        return $line;
    }

}

