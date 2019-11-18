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

	class dividExceptionZero extends \CBitrixComponent
    {
        /** @var int */
        //static protected $questionNumber = 0;

        public function __construct($component = null) {
            parent::__construct($component);
            //$this->errorCollection = new \Bitrix\Main\ErrorCollection();
        }

        public function checkModules() {

            if (!\Bitrix\Main\Loader::includeModule("grom.mymodule")) {
                //ShowError(Loc::getMessage("GROM_MYMODULE_MODULE_NOT_INSTALED"));
                //return false;
                throw new \Bitrix\Main\LoaderEsception(Loc::getMessage("GROM_MYMODULE_MODULE_NOT_INSTALED"));

            }

        }

        public function var1() {

            $arResult = \Grom\Mymodule\Division::divided('4','3');
            //$srResult = \Grom\Mymodule\Division::divided('4','0');
            return $arResult;
        }

        public function executeComponent() {

            try {

                //Подключает языковые файлы
                $this->includeComponentLang("class.php");

                //Проверка на подключение модуля grom.mymodule
                $this->checkModules();

                //if ($APPLICATION->GetGroupRight('grom.mymodule') < "S") {
                //    ShowError(Loc::getMessage("ACCESS_DENIED"));
                //} else {

                    //Запускаем ф-ю деления на нуль
                    $this->arResult["RESULT"] = $this->var1();
                    $this->arResult["Division2/7"] = \Grom\Mymodule\Division::divided('2','7');
                    $this->arResult["NotPsr4One"] = \Grom\Mymodule\NotPsr4One::getParam("param1");
                    $this->arResult["NotPsr4Two"] = \Grom\Mymodule\NotPsr4Two::getParam("param1");

                    //Подключение шаблона
                    $this->includeComponentTemplate();

                //}

            } catch (\Grom\Mymodule\DivisionError $e) {

                ShowError($e->getMessage()); //Текст ошибки
                print_r('<br/>Вывод<pre>');
                print_r($e->getParam1()); print_r('<br/>'); //Методы Нашего класса исключений
                print_r($e->getParam2()); print_r('<br/>');
                print_r('</pre>');

            }


        }
    }

