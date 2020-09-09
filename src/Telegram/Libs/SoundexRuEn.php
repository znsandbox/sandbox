<?php

namespace ZnSandbox\Telegram\Libs;

use ZnSandbox\Telegram\Helpers\TranslitHelper;

class SoundexRuEn
{

    function encodeSoundex(string $string): string
    {
        $string = $this->MetaPhoneRus($string);
        $string = TranslitHelper::translit($string);
        return soundex($string);
    }

    function encodeMetaphone(string $string): string
    {
        $string = $this->MetaPhoneRus($string);
        $string = TranslitHelper::translit($string);
        return metaphone($string);
    }

    private function isCyrillic($string): bool {
        return preg_match('#[А-Яа-я]#i', $string) === 1;
    }

    function dmstring($string)
    {
        $is_cyrillic = $this->isCyrillic($string);
        if($is_cyrillic) {
            $string = TranslitHelper::translit($string);
        }

        $string = preg_replace(array('#[^\w\s]|\d#i', '#\b[^\s]{1,3}\b#i', '#\s{2,}#i', '#^\s+|\s+$#i'),
            array('', '', ' '), strtoupper($string));

        if (!isset($string[0]))
            return null;

        $matches = explode(' ', $string);
        foreach($matches as $key => $match)
            $matches[$key] = $this->dmword($match, $is_cyrillic);
        return $matches;
    }

    private function dmword($string, $is_cyrillic = true)
    {
        static $codes = array(
            'A' =>    array(array(0, -1, -1),
                'I' =>    array(array(0, 1, -1)),
                'J' =>    array(array(0, 1, -1)),
                'Y' =>    array(array(0, 1, -1)),
                'U' =>    array(array(0, 7, -1))),

            'B' =>    array(array(7, 7, 7)),

            'C' =>    array(array(5, 5, 5), array(4, 4, 4),
                'Z' =>     array(array(4, 4, 4),
                    'S' =>    array(array(4, 4, 4))),
                'S' =>    array(array(4, 4, 4),
                    'Z' =>    array(array(4, 4, 4))),
                'K' =>    array(array(5, 5, 5), array(45, 45, 45)),
                'H' =>    array(array(5, 5, 5), array(4, 4, 4),
                    'S' =>    array(array(5, 54, 54)))),

            'D' =>    array(array(3, 3, 3),
                'T' =>    array(array(3, 3, 3)),
                'Z' =>    array(array(4, 4, 4),
                    'H' =>    array(array(4, 4, 4)),
                    'S' =>    array(array(4, 4, 4))),
                'S' =>    array(array(4, 4, 4),
                    'H' =>    array(array(4, 4, 4)),
                    'Z' =>    array(array(4, 4, 4))),
                'R' =>    array(
                    'S' =>    array(array(4, 4, 4)),
                    'Z' =>    array(array(4, 4, 4)))),

            'E' =>    array(array(0, -1, -1),
                'I' =>    array(array(0, 1, -1)),
                'J' =>    array(array(0, 1, -1)),
                'Y' =>    array(array(0, 1, -1)),
                'U' =>    array(array(1, 1, -1))),

            'F' =>    array(array(7, 7, 7),
                'B' =>    array(array(7, 7, 7))),

            'G' =>    array(array(5, 5, 5)),

            'H' =>    array(array(5, 5, -1)),

            'I' =>    array(array(0, -1, -1),
                'A' =>    array(array(1, -1, -1)),
                'E' =>    array(array(1, -1, -1)),
                'O' =>    array(array(1, -1, -1)),
                'U' =>    array(array(1, -1, -1))),

            'J'    =>    array(array(4, 4, 4)),

            'K' =>    array(array(5, 5, 5),
                'H' =>    array(array(5, 5, 5)),
                'S' =>    array(array(5, 54, 54))),

            'L' =>    array(array(8, 8, 8)),

            'M' =>    array(array(6, 6, 6),
                'N' =>    array(array(66, 66, 66))),

            'N' =>    array(array(6, 6, 6),
                'M' =>    array(array(66, 66, 66))),

            'O' =>    array(array(0, -1, -1),
                'I' =>    array(array(0, 1, -1)),
                'J' =>    array(array(0, 1, -1)),
                'Y' =>    array(array(0, 1, -1))),

            'P' =>    array(array(7, 7, 7),
                'F'    =>    array(array(7, 7, 7)),
                'H'    =>    array(array(7, 7, 7))),

            'Q' =>    array(array(5, 5, 5)),

            'R' =>    array(array(9, 9, 9),
                'Z'    =>    array(array(94, 94, 94), array(94, 94, 94)), // special case
                'S' =>    array(array(94, 94, 94), array(94, 94, 94))), // special case

            'S' =>    array(array(4, 4, 4),
                'Z' =>    array(array(4, 4, 4),
                    'T' =>    array(array(2, 43, 43)),
                    'C' =>    array(
                        'Z' => array(array(2, 4, 4)),
                        'S' => array(array(2, 4, 4))),
                    'D' =>    array(array(2, 43, 43))),
                'D' =>    array(array(2, 43, 43)),
                'T' =>    array(array(2, 43, 43),
                    'R'    =>    array(
                        'Z' =>    array(array(2, 4, 4)),
                        'S' =>    array(array(2, 4, 4))),
                    'C' =>    array(
                        'H' =>    array(array(2, 4, 4))),
                    'S' =>    array(
                        'H'    =>    array(array(2, 4, 4)),
                        'C' =>    array(
                            'H' =>    array(array(2, 4, 4))))),
                'C'    =>    array(array(2, 4, 4),
                    'H' =>    array(array(4, 4, 4),
                        'T' => array(array(2, 43, 43),
                            'S' => array(
                                'C' => array(
                                    'H' =>    array(array(2, 4, 4))),
                                'H' => array(array(2, 4, 4))),
                            'C' => array(
                                'H' =>    array(array(2, 4, 4)))),
                        'D' =>    array(array(2, 43, 43)))),
                'H' =>    array(array(4, 4, 4),
                    'T'    =>    array(array(2, 43, 43),
                        'C' =>    array(
                            'H' =>    array(array(2, 4, 4))),
                        'S' =>    array(
                            'H' =>    array(array(2, 4, 4)))),
                    'C'    =>    array(
                        'H' =>    array(array(2, 4, 4))),
                    'D' =>    array(array(2, 43, 43)))),

            'T' =>    array(array(3, 3, 3),
                'C' =>    array(array(4, 4, 4),
                    'H' =>    array(array(4, 4, 4))),
                'Z'    =>    array(array(4, 4, 4),
                    'S' =>    array(array(4, 4, 4))),
                'S' =>    array(array(4, 4, 4),
                    'Z' =>    array(array(4, 4, 4)),
                    'H' =>    array(array(4, 4, 4)),
                    'C' =>    array(
                        'H' =>    array(array(4, 4, 4)))),
                'T' =>    array(
                    'S' =>    array(array(4, 4, 4),
                        'Z' =>    array(array(4, 4, 4)),
                        'C' =>    array(
                            'H' =>    array(array(4, 4, 4)))),
                    'C' =>    array(
                        'H' =>    array(array(4, 4, 4))),
                    'Z' =>    array(array(4, 4, 4))),
                'H' =>    array(array(3, 3, 3)),
                'R' =>    array(
                    'Z' =>    array(array(4, 4, 4)),
                    'S' =>    array(array(4, 4, 4)))),

            'U' =>    array(array(0, -1, -1),
                'E' =>    array(array(0, -1, -1)),
                'I' =>    array(array(0, 1, -1)),
                'J' =>    array(array(0, 1, -1)),
                'Y' =>    array(array(0, 1, -1))),

            'V' =>    array(array(7, 7, 7)),

            'W' =>    array(array(7, 7, 7)),

            'X' =>    array(array(5, 54, 54)),

            'Y' =>    array(array(1, -1, -1)),

            'Z' =>    array(array(4, 4, 4),
                'D' =>    array(array(2, 43, 43),
                    'Z' =>    array(array(2, 4, 4),
                        'H' =>    array(array(2, 4, 4)))),
                'H' =>    array(array(4, 4, 4),
                    'D' => array(array(2, 43, 43),
                        'Z' =>    array(
                            'H' =>    array(array(2, 4, 4))))),
                'S' =>    array(array(4, 4, 4),
                    'H' =>    array(array(4, 4, 4)),
                    'C' =>    array(
                        'H' =>    array(array(4, 4, 4))))));

        $length = strlen($string);
        $output = '';
        $i = 0;

        $previous = -1;

        while ($i < $length)
        {
            $current = $last = &$codes[$string[$i]];

            for ($j = $k = 1; $k < 7; $k++)
            {
                if (!isset($string[$i + $k]) ||
                    !isset($current[$string[$i + $k]]))
                    break;

                $current = &$current[$string[$i + $k]];

                if (isset($current[0]))
                {
                    $last = &$current;
                    $j = $k + 1;
                }
            }

            if ($i == 0)
                $code = $last[0][0];
            elseif (!isset($string[$i + $j]) || ($codes[$string[$i + $j]][0][0] != 0))
                $code = $is_cyrillic ? (isset($last[1]) ? $last[1][2] : $last[0][2]) : $last[0][2];
            else
                $code = $is_cyrillic ? (isset($last[1]) ? $last[1][1] : $last[0][1]) : $last[0][1];

            if (($code != -1) && ($code != $previous))
                $output .= $code;

            $previous = $code;

            $i += $j;

        }

        return str_pad(substr($output, 0, 6), 6, '0');
    }

    function MetaPhoneRus($word, $surname = false)
    {
        $is_cyrillic = $this->isCyrillic($word);
        if(! $is_cyrillic) {
            return $word;
        }
        //mb_internal_encoding('UTF-8');
        $word = mb_strtolower($word);
        $word = preg_replace('/[^оеаиуэюяпстрклмнбвгджзйфхцчшщыё]/u', '', $word);

        //Исключение повторяющихся символов
        $word = preg_replace('/(.)\\1+/u', '$1', $word);

        //Сжатие окончаний
        if($surname)
        {
            $endings = array(
                'овский' => '@',
                'евский' => '#',
                'овская' => '$',
                'евская' => '%',
                'иева' => '9',
                'еева' => '9',
                'ова' => '9',
                'ева' => '9',
                'ина' => '1',
                'иев' => '4',
                'еев' => '4',
                'нко' => '3',
                'ов' => '4',
                'ев' => '4',
                'ая' => '6',
                'ий' => '7',
                'ый' => '7',
                'ых' => '5',
                'их' => '5',
                'ин' => '8',
                'ик' => '2',
                'ек' => '2',
                'ук' => '0',
                'юк' => '0'
            );
            foreach($endings as $match => $replacement)
            {
                $count = 0;
                $word = preg_replace('/' . $match . '$/u', $replacement, $word, 1, $count);
                if($count > 0) break;
            }
        }

        //Замена гласных
        $vowelsReplacement = array(
            [
                array('йо', 'ио', 'йе', 'ие'),
                'и'
            ],
            [
                array('о', 'ы', 'я'),
                'a'
            ],
            [
                array('е', 'ё', 'э'),
                'и'
            ],
            [
                array('ю'),
                'у'
            ],
        );

        foreach($vowelsReplacement as $item)
        {
            $word = str_replace($item[0], $item[1], $word);
        }

        $word = preg_replace('/(.)\\1+/u', '$1', $word);

        //Оглушение согласных в слабой позиции (перед не сонорными согласными и на конце слов)
        $dullReplacement = array(
            'б' => 'п',
            'з' => 'с',
            'д' => 'т',
            'в' => 'ф',
            'г' => 'к'
        );

        foreach($dullReplacement as $search => $replace)
        {
            $word = preg_replace("/{$search}([псткбвгджзфхцчшщ])|{$search}()$/u", "{$replace}$1", $word);
        }

        //Исключение повторяющихся символов
        $word = preg_replace('/(.)\\1+/u', '$1', $word);


        return $word;
    }
}
