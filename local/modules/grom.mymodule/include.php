<?
/*
 * Файл используется для подключения скриптов не подключающихся автоматически с папки /lib
 *
 * */
?>
<?
use \Bitrix\Main\Loader;
?>
<?
/*
 * Ф-я автоподключения классов
 * */
\CModule::AddAutoloadClasses(
    '',
    array(
        'Grom\Mymodule\NotPsr4One' => '/local/modules/grom.mymodule/lib/all.php',
        'Grom\Mymodule\NotPsr4Two' => '/local/modules/grom.mymodule/lib/all.php',
    )
);
?>
<?


?>
