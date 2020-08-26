<?php

namespace PhpLab\Sandbox\Bot\Domain\Helpers;

class MlHelper
{

    static public function prepareWord($line)
    {
        $line = \PhpLab\Core\Helpers\StringHelper::filterChar($line, '#[^а-яА-ЯёЁa-zA-Z\s]+#u');
        return $line;
    }

}

