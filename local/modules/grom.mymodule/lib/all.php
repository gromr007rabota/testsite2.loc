<?php
/**
 * Класс с ручной автозагрузкой в include.php
 * Имеет внутри два класса со своими названиями
 * это уже не по psr-4
 *
 */
namespace Grom\Mymodule;

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class NotPsr4One
{
    public static function getParam($param)
    {
        $result = 'yes';
        return $result;
    }
}

class NotPsr4Two
{
    public static function getParam($param)
    {
        return 'resul';
    }
}