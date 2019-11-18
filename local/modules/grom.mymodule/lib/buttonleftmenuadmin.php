<?php
/**
 * Класс расширяющий меню
 */
namespace Grom\Mymodule;

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/*
 *
 * */

class ButtonLeftMenuAdmin
{
    public function OnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
    {

        // Добавляем пункт в наше меню
        $aModuleMenu[] = array(
            "parent_menu" => "global_menu_mymodule",
            "icon" => "default_menu_icon",
            "page_icon" => "default_page_icon",
            "sort"=>"200",
            "text"=>"Настройки моего модуля",
            "title"=>"Настройки моего модуля",
            "url"=>"/bitrix/admin/grom_mymoduleadmin.php",
            "more_url"=>array(),
        );
        // нужен хотя бы один пункт в глобальном разделе, иначе раздел не появится
        $aModuleMenu[] = array(
            "parent_menu" => "global_menu_mymodule",
            "icon" => "default_menu_icon",
            "page_icon" => "default_page_icon",
            "sort"=>"100",
            "text"=>"Права моего модуля",
            "title"=>"Права моего модуля",
            "url"=>"/bitrix/admin/grom_mymoduleadmin.php",
            "more_url"=>array(),
        );

        // Добавим в меню сервисы
        $aModuleMenu[] = array(
            "parent_menu" => "global_menu_services",
            "icon" => "default_menu_icon",
            "page_icon" => "default_page_icon",
            "sort"=>"1000",
            "text"=>"Из класса grom.Mymodule/lib/buttonleftmenuadmin.php",
            "title"=>"Кнопка в секции Сервисы",
            "url"=>"/bitrix/admin/grom_mymoduleadmin.php",
            "more_url"=>array(),
        );

        // Добавляет глобальный раздел
        $arRes = array(
            "global_menu_mymodule" => array(
                "menu_id" => "grom.mymodule",
                "page_icon" => "services_title_icon",
                "index_icon" => "services_page_icon",
                "text" => "Мой модуль",
                "title" => "Мой модуль",
                "sort" => 900,
                "items_id" => "global_menu_mymodule",
                "help_section" => "custom",
                "items" => array()
            ),
        );

        return $arRes;




    }
}
