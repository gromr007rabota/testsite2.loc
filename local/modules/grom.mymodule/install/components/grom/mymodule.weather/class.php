<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Config;

//use \Bitrix\Main\Web\Json;
//use \Bitrix\Main\Error;
//use \Bitrix\Main\ErrorCollection;
//use \Bitrix\Vote\Base\Diag;
//use \Bitrix\Main\ArgumentException;

	class CMymoduleClass extends \CBitrixComponent
    {
        /** @var int */
        static protected $questionNumber = 0;

        public function __construct($component = null) {
            parent::__construct($component);
            //$this->errorCollection = new \Bitrix\Main\ErrorCollection();
        }

        public function checkModules() {

            if (Loader::includeModule("grom.mymodule")) {
                ShowError(Loc::getMessage("GROM_MYMODULE_MODULE_NOT_INSTALED"));
                return false;
            }

        }

        public function executeComponent() {

            //Подключает языковые файлы
            $this->includeComponentLang("class.php");

            //Проверка на подключение модуля grom.mymodule
            if ($this->checkModules()) {

               $this->includeComponentTemplate();

            }
        }
    }

