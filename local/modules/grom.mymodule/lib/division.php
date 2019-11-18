<?php
/**
 * Класс Кидающий исключение DivisionError
 */
namespace Grom\Mymodule;

use \Bitrix\Main\Localization\Loc;
use \Grom\Mymodule\DivisionError;

Loc::loadMessages(__FILE__);

class Division
{

    protected $param1;
    protected $param2;

    /**
     *
     * \Grom\Mymodule\Division::divided('2','0');
     * @return string
     */

    public static function divided ($param1=0,$param2=0)
    {
        if ($param2 == 0) {
            //Вызываем свое Исключение
            throw new DivisionError("Деление на нуль", $param1, $param2);
        }

        $result = $param1/$param2;

        return $result;
    }



}