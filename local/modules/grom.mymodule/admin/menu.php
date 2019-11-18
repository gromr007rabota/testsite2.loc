<?
/*
 * Здесь можно задать пункт админ меню и поместить его в уже имеющуюся группу слева например в сервис
 *
 *
 * */

$aMenu = array(
	"parent_menu" => "global_menu_services",
	"sort" => 1000,
	"module_id" => "grom.mymodule",
	"text" => "Меню из файла grom.mymodule/admin/menu.php",
	"title" => "Какое то описание",
	"icon" => "services_page_icon",
	"page_icon" => "services_page_icon",
	"items_id" => "menu_mymodule",
	"items" => array(
		array(
            "title" => "Я элемент меню",
			"text" => "Тоже какойто текст",
			"items_id" => "menu_mymodule_channels",
            "url"=>"/bitrix/admin/grom_mymoduleadmin.php",
            "icon" => "services_page_icon",
            "page_icon" => "services_page_icon",
            "sort" => 100,
            //"items" => $menuResults1
		)
	)
);

return $aMenu;




?>