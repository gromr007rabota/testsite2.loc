<?
//use \Bitrix\Main\Config as Conf;
//use \Bitrix\Main\Loader;
//use \Bitrix\Main\Entity\Base;


use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Aplication;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\ModuleManager;
use \Bitrix\Main\IO\Directory;
use \Bitrix\Main\EventManager;

Loc::loadMessages(__FILE__);

if(class_exists("grom_mymodule")) return;
Class grom_mymodule extends CModule
{
    /*
     * Главный класс модуля
     *
     * */

	var $MODULE_ID;
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $PARTNER_NAME;
	var $PARTNER_URI;
	var $SHOW_SUPER_ADMINGROUP_RIGHTS;
	var $MODULE_GROUP_RIGHTS;


    /*
     * Заполняем внутренние переменные
     * */
	function __construct() {

	    $arModuleVersion = array();
	    include(__DIR__."/version.php");
        $this->MODULE_ID = "grom.mymodule"; //Имя модуля - папка
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("GROM_MYMODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("GROM_MYMODULE_DESCRIPTION");
        $this->PARTNER_NAME = Loc::getMessage("GROM_MYMODULE_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("GROM_MYMODULE_PARTNER_URI");
        $this->SHOW_SUPER_ADMINGROUP_RIGHTS = "Y"; //Будет возможен выбор администраторов на вкладке доступа
        $this->MODULE_GROUP_RIGHTS = "Y";
    }



    /*
     * Запускается при установке
     * */
    function DoInstall()
    {
        global $DB, $APPLICATION;

        if ($this->isVersionD7()) {

            //Регистрируем модуль
                \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);

            $this->InstallDB();

            $this->InstallEvents();

            $this->InstallFiles();

            //Кладем данные в секцию .setting.php Колличество запусков
                $configuration = \Bitrix\Main\Config\Configuration::getInstance();
                $gromModuleMymodule = $configuration->get("grom_module_mymodule");
                $gromModuleMymodule["install"] = $gromModuleMymodule["install"]+1;
                $configuration->add("grom_module_mymodule",$gromModuleMymodule);
                $configuration->saveConfiguration();
        } else {
            $APPLICATION->ThrowException(Loc::getMessage("GROM_MYMODULE_ERROR_D7"));
        }

        //Запускаем страницу установки
            $APPLICATION->IncludeAdminFile(GetMessage("GROM_MYMODULE_INSTALL_TITLE"), $this->getPath()."/install/step.php");

    }

    /*
    * Запускается при удалении
    * */
    function DoUninstall()
    {
        global $DB, $APPLICATION;

        //Получаем входные данные через Приложение контекст
            $context = \Bitrix\Main\APPLICATION::getInstance()->getContext();
            $request = $context->getRequest();

        if ($request["step"] < 2) {

            //Экран приветствия
                $APPLICATION->IncludeAdminFile(Loc::getMessage("GROM_MYMODULE_UNINSTALL_TITLE"), $this->getPath()."/install/unstep1.php");

        } elseif ($request["step"] == 2) {

            //Удаляем События
                $this->UnInstallEvents();
            //Удаляем файлы
                $this->UnInstallFiles();
            //Удаляем из БД
                if($request["savedata"] != "Y") {
                    $this->UnInstallDB();
                }

            //Кладем данные в секцию .setting.php Колличество удалений модуля
                $configuration = \Bitrix\Main\Config\Configuration::getInstance();
                $gromModuleMymodule = $configuration->get("grom_module_mymodule");
                $gromModuleMymodule["uninstall"] = $gromModuleMymodule["uninstall"]+1;
                $configuration->add("grom_module_mymodule",$gromModuleMymodule);
                $configuration->saveConfiguration();


            //Удаляем модуль
                \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
            //Завершающий экран
                $APPLICATION->IncludeAdminFile(Loc::getMessage("VOTE_UNINSTALL_TITLE"),$this->getPath()."/install/unstep2.php");
        }

    }




    /*
     * Проверяет что поддерживается D7
     * */
    public function isVersionD7() {
	    return CheckVersion(\Bitrix\Main\ModuleManager::getVersion("main"),"14.00.00");
    }

    /*
     * Проверяет что модуль установлен
     * */
    public function isModuleInstalled($nameModule) {
	    return \Bitrix\Main\ModuleManager::isModuleInstalled($nameModule);
    }

    /*
     * Формирует путь до файлов модуля
     * */
    public function getPath($notDocumentRoot=false) {
        if ($notDocumentRoot) {
            return str_replace(\Bitrix\Main\Application::getDocumentRoot(),'',dirname(__DIR__));
        } else {
            return dirname(__DIR__);
        }

    }



    /*
     * Ф-я установки прав доступа
     * */
	function GetModuleRightList()
	{
        return array(
            "reference_id" => array("D","K","S","W"),
            "reference" => array(
                "[D]".Loc::getMessage("GROM_MYMODULE_DENIED"),
                "[K]".Loc::getMessage("GROM_MYMODULE_READ_COMPONENT"),
                "[S]".Loc::getMessage("GROM_MYMODULE_WRITE_SETTINGS"),
                "[W]".Loc::getMessage("GROM_MYMODULE_FULL")
            ),
        );
    }

    //Формируем кнопку в меню
	function AddGlobalMenuItem()
	{
       $aModuleMenu[] = array(

       );
    }




    /*
     * Создаем базы данных
     * */
	function InstallDB($arParams = array())
	{
		/*
	    global $DB, $DBType, $APPLICATION;
		$this->errors = false;

		// Database tables creation
		if(!$DB->Query("SELECT 'x' FROM b_vote WHERE 1=0", true))
			$this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/vote/install/db/".strtolower($DB->type)."/install.sql");

		if($this->errors !== false)
		{
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}
		else
		{

			COption::SetOptionString("vote", "VOTE_DIR", "");
			COption::SetOptionString("vote", "VOTE_COMPATIBLE_OLD_TEMPLATE", "N");

			$eventManager = \Bitrix\Main\EventManager::getInstance();
			$eventManager->registerEventHandlerCompatible("main", "OnBeforeProlog", "main", "", "", 10, "/modules/vote/keepvoting.php");
			$eventManager->registerEventHandlerCompatible("main", "OnUserTypeBuildList", "vote", "Bitrix\\Vote\\Uf\\VoteUserType", "getUserTypeDescription", 200);
			$eventManager->registerEventHandlerCompatible("main", "OnUserLogin", "vote", "Bitrix\\Vote\\User", "onUserLogin", 200);
			$eventManager->registerEventHandlerCompatible("im", "OnGetNotifySchema", "vote", "CVoteNotifySchema", "OnGetNotifySchema");

			RegisterModule("vote");

		}
		*/
        return true;

	}


    /*
    * Удаляем базы данных
    * */
	function UnInstallDB($arParams = array())
	{

    //Удаляем из базы данне модуля
    \Bitrix\Main\Config\Option::delete($this->MODULE_ID);

	/*
	    global $DB, $DBType, $APPLICATION;
		$this->errors = false;

		if(!array_key_exists("savedata", $arParams) || $arParams["savedata"] != "Y")
		{
			$this->UnInstallUserFields();
			$this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/vote/install/db/".strtolower($DB->type)."/uninstall.sql");
		}

		//delete agents
		CAgent::RemoveModuleAgents("vote");

		$db_res = $DB->Query("SELECT ID FROM b_file WHERE MODULE_ID = 'vote'");
		while($arRes = $db_res->Fetch())
			CFile::Delete($arRes["ID"]);

		// Events
		include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/vote/install/events/del_events.php");

		COption::RemoveOption("vote");

		UnRegisterModuleDependences("im", "OnGetNotifySchema", "vote", "CVoteNotifySchema", "OnGetNotifySchema");
		UnRegisterModuleDependences("main", "OnUserLogin", "vote", "Bitrix\\Vote\\User", "onUserLogin");
		UnRegisterModuleDependences("main", "OnUserTypeBuildList", "vote", "Bitrix\\Vote\\Uf\\VoteUserType", "getUserTypeDescription");
		UnRegisterModuleDependences("main", "OnBeforeProlog", "main", "", "", "/modules/vote/keepvoting.php");
		UnRegisterModule("vote");

		if($this->errors !== false)
		{
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}
*/

        return true;
	}

    /*
     * Регистрируем события
     * */
	function InstallEvents()
	{

		/*
        use Bitrix\Main\EventManager;
        $handler = EventManager::getInstance()->addEventHandler(
            "main",
            "OnUserLoginExternal",
            array(
                "Intervolga\\Test\\EventHandlers\\Main",
                "onUserLoginExternal"
            )
        );
        EventManager::getInstance()->removeEventHandler(
            "main",
            "OnUserLoginExternal",
            $handler
        );
        EventManager::getInstance()->registerEventHandler(
            "main",
            "OnProlog",
            $this->MODULE_ID,
            "Intervolga\\Test\\EventHandlers",
            "onProlog"
        );
        EventManager::getInstance()->unRegisterEventHandler(
            "main",
            "OnProlog",
            $this->MODULE_ID,
            "Intervolga\\Test\\EventHandlers",
            "onProlog"
        );
        $handlers = EventManager::getInstance()->findEventHandlers("main", "OnProlog");
        */

        //Устанавливаем кнопку модуля на левой панеле админки
            $eventManager = \Bitrix\Main\EventManager::getInstance();
            $eventManager->registerEventHandler( "main", "OnBuildGlobalMenu", $this->MODULE_ID, '\Grom\Mymodule\ButtonLeftMenuAdmin', "OnBuildGlobalMenu");

        return true;
	}

    /*
    * Удаляем события
    * */
	function UnInstallEvents()
	{

        //Удаляем кнопку модуля на левой панеле админки
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler( "main", "OnBuildGlobalMenu", $this->MODULE_ID, '\Grom\Mymodule\ButtonLeftMenuAdmin', "OnBuildGlobalMenu");

        return true;
	}

    /*
    * Копируем файлы модуля
    * */
	function InstallFiles($arParams = array())
	{
	    //Копируем компоненты - откуда, куда, перезапись при конфликте, рекурсивно
        CopyDirFiles($this->getPath()."/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components",true,true);

        //Копируем ссылочные скрипты админки
        if(\Bitrix\Main\IO\Directory::isDirectoryExists($path=$this->getPath()."/admin" ) ) {
            CopyDirFiles($this->getPath()."/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
        }

        //Копируем css, js
        //CopyDirFiles($this->getPath()."/install/images", $_SERVER["DOCUMENT_ROOT"]."/bitrix/images/grom.mymodule");
        //CopyDirFiles($this->getPath()."/install/js", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js/grom.mymodule");
        //CopyDirFiles($this->getPath()."/install/css", $_SERVER["DOCUMENT_ROOT"]."/bitrix/css/grom.mymodule");

        return true;
	}

	/*
    * Удаляем Файлы модуля
    * */
	function UnInstallFiles()
	{
	    //Удаляем все компоненты
            \Bitrix\Main\IO\Directory::deleteDirectory($_SERVER["DOCUMENT_ROOT"]."/bitrix/components/grom/");

        //Удаляем из /bitrix/admin/
            if(\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->getPath()."/admin")) {
                DeleteDirFiles($this->getPath()."/install/admin/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin/");//Ищет файлы из первого парраметра по пути и удаляет по пути из второго
            }

        return true;
	}

}
?>