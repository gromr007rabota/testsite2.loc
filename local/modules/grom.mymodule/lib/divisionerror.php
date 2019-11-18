<?php
/**
 * Класс расширяющий исключения
 */
namespace Grom\Mymodule;

use \Bitrix\Main\Localization\Loc;


Loc::loadMessages(__FILE__);

class DivisionError extends \Bitrix\Main\SystemException
{

    protected $param1;
    protected $param2;

    /**
     *
     *
     * @return string
     */
    public function __construct ($mess="division by zero",  $param1=0,  $param2=0, \Exception $previous=null)
    {
        $message = "An error: ".$mess;
        $this->param1 = $param1;
        $this->param2 = $param2;

        parent::__construct($message,false,false,false, $previous); // message code file line prev

        return "";
    }

    public function getParam1 ()
    {
        echo $this->param1;
    }
    public function getParam2 ()
    {
        echo $this->param2;
    }


}