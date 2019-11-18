<?
    /*
     * Файл настроек модуля в админке,
     * @$APPLICATION
     *
     * */

    use \Bitrix\Main\Aplication;
    use \Bitrix\Main\Localization\Loc;
    use \Bitrix\Main\ModuleManager;
    use \Bitrix\Main\IO\Directory;
    use \Bitrix\Main\Config\Option;

    // Обязательно для прав доступа
        $module_id = "grom.mymodule";

    //Подключаем файл с сообщениями главного модуля
        Loc::loadMessages($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/option.php");
        Loc::loadMessages(__FILE__);

    //Проверяем права на изменения модуля
        $muModuleRight = $APPLICATION->GetGroupRight($module_id);
        if ($muModuleRight<"S") {
            $APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));
        }

    //Подключаем модуль
        \Bitrix\Main\Loader::includeModule($module_id); //Не будет текущий файл подключен если модуль не подключится


    //Берем данные по входящему запросу
        $request = \Bitrix\Main\HttpApplication::getInstance()->getContext()->getRequest();



    //Массив вкладок и элементов //
        $aTabs = array(
            array(
                "DIV" => "edit1",
                "TAB" => Loc::getMessage("GROM_MYMODULE_TAB_SET"),
                "ICON" => "vote_settings",
                "TITLE" => Loc::getMessage("GROM_MYMODULE_FIELD_TITLE_SET"),
                "OPTIONS" => array(
                    array(
                        'field_text', //name свойства
                        Loc::getMessage("GROM_MYMODULE_FIELD_TEXT_TITLE"),
                        '', //По умолчанию
                        array('textarea', 10, 50) //тип поля и размер
                    ),
                    array(
                        'field_line',
                        Loc::getMessage("GROM_MYMODULE_FIELD_LINE_TITLE"),
                        '',
                        array('text', 10)
                    ),
                    array(
                        'field_list',
                        Loc::getMessage("GROM_MYMODULE_FIELD_LIST_TITLE"),
                        '',
                        array('multiselectbox', array('var1'=>'var1','var2'=>'var2','var3'=>'var3','var4'=>'var4'))
                    )
                )
            ),
            array(
                "DIV" => "edit2",
                "TAB" => Loc::getMessage("GROM_MYMODULE_TAB_RIGHTS"),
                "ICON" => "vote_settings",
                "TITLE" => Loc::getMessage("GROM_MYMODULE_FIELD_TITLE_RIGHTS")
            ),
        );

    ?>
    <?//Выводим страницы?>
    <?$tabControl = new CAdminTabControl("tabControl", $aTabs); //tabControl - id формы?>
    <?$tabControl->Begin();?>


        <form method="post" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?=LANGUAGE_ID?>" name="grom_mymodule_settings">

            <?
            foreach ($aTabs as $aTab) {
                if ($aTab["OPTIONS"]) {
                    $tabControl->BeginNextTab();
                    __AdmSettingsDrawList($module_id,$aTab["OPTIONS"]);
                }
            }
            ?>

            <?$tabControl->BeginNextTab();?>
            <?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");?>
            <?$tabControl->Buttons();?>

            <input type="submit" name="Update" value="<?=Loc::getMessage("MAIN_SAVE")?>" />
            <input type="reset" name="reset" value="<?=Loc::getMessage("MAIN_RESET")?>" />
            <?=bitrix_sessid_post()?>
        </form>

    <?$tabControl->End();?>

    <?
    //Проверяем и сохраняем данные формы

    if ($request->isPost() && $request["Update"] && check_bitrix_sessid()) {
        foreach ($aTabs as $aTab) {
            foreach ($aTab["OPTIONS"] as $arOption) {


                if (!is_array($arOption))
                    continue; // Пропускаем строки с подсветкой

                if ($arOption["note"])
                    continue; // Пропускаем уведомления с подсветкой

                //__AdmSettingsSaveOptions($module_id,$arOption[0]);

                $optionName = $arOption[0];
                $optionValue = $request->getPost($optionName);
                \Bitrix\Main\Config\Option::set($module_id,$optionName,is_array($optionValue) ? implode(',', $optionValue): $optionValue);
            }
        }


    }


?>
<?/*
    $VOTE_RIGHT = $APPLICATION->GetGroupRight($module_id);
    if ($VOTE_RIGHT>="R")
    {



        <?
        $tabControl->Begin();
        ?><form method="post" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?=LANGUAGE_ID?>">
        <?=bitrix_sessid_post()?>
        <?$tabControl->BeginNextTab();?>
        <?$tabControl->BeginNextTab();?>
        <?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");?>
        <?$tabControl->Buttons();?>
        <?$tabControl->End();?>
    }




require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/vote/include.php");
$old_module_version = CVote::IsOldVersion();

$module_id = "vote";
$VOTE_RIGHT = $APPLICATION->GetGroupRight($module_id);
if ($VOTE_RIGHT>="R")
{

	$arAllOptions = $arDisplayOptions = array(
		array("USE_HTML_EDIT", GetMessage("VOTE_USE_HTML_EDIT"), Array("checkbox", "Y")),
		array("VOTE_COMPATIBLE_OLD_TEMPLATE", GetMessage("VOTE_COMPATIBLE"), Array("checkbox", "Y")),
		array("VOTE_DIR", GetMessage("VOTE_PUBLIC_DIR"), array("text", 45)),
		array("VOTE_TEMPLATE_PATH", GetMessage("VOTE_TEMPLATE_VOTES"), array("text", 45)),
		array("VOTE_TEMPLATE_PATH_VOTE", GetMessage("VOTE_TEMPLATE_RESULTS_VOTE"), array("text", 45)),
		array("VOTE_TEMPLATE_PATH_QUESTION", GetMessage("VOTE_TEMPLATE_RESULTS_QUESTION"), array("text", 45)),
		array("VOTE_TEMPLATE_PATH_QUESTION_NEW", GetMessage("VOTE_TEMPLATE_RESULTS_QUESTION_NEW"), array("text", 45)),
		
	);

	if ($REQUEST_METHOD=="GET" && $VOTE_RIGHT=="W" && strlen($RestoreDefaults)>0 && check_bitrix_sessid())
	{
		COption::RemoveOption("vote");
		$z = CGroup::GetList($v1="id",$v2="asc", array("ACTIVE" => "Y", "ADMIN" => "N"));
		while($zr = $z->Fetch())
			$APPLICATION->DelGroupRight($module_id, array($zr["ID"]));
	}

	if($REQUEST_METHOD=="POST" && strlen($Update)>0 && $VOTE_RIGHT=="W" && check_bitrix_sessid())
	{
		while(list($key,$name)=each($arAllOptions))
		{
			$val = ${$name[0]};

			if($name[2][0]=="checkbox" && $val != "Y") 
				$val="N";
			elseif(!array_key_exists($name[0], $_POST))
				continue;

			COption::SetOptionString($module_id, $name[0], $val);
		}
	}

	if (COption::GetOptionString("vote", "VOTE_COMPATIBLE_OLD_TEMPLATE", "N") == "N")
	{
		unset($arDisplayOptions[2]);
		unset($arDisplayOptions[3]);
		unset($arDisplayOptions[4]);
		unset($arDisplayOptions[5]);
		unset($arDisplayOptions[6]);
	}
	elseif ($old_module_version=="Y")
	{
		unset($arDisplayOptions[6]);
	}
	else
	{
		unset($arDisplayOptions[2]);
		unset($arDisplayOptions[3]);
		unset($arDisplayOptions[4]);
		unset($arDisplayOptions[5]);
	}


	$aTabs = array(
		array("DIV" => "edit1", "TAB" => GetMessage("MAIN_TAB_SET"), "ICON" => "vote_settings", "TITLE" => GetMessage("MAIN_TAB_TITLE_SET")),
		array("DIV" => "edit2", "TAB" => GetMessage("MAIN_TAB_RIGHTS"), "ICON" => "vote_settings", "TITLE" => GetMessage("MAIN_TAB_TITLE_RIGHTS")),
	);
	$tabControl = new CAdminTabControl("tabControl", $aTabs);
	?>
	<?
	$tabControl->Begin();
	?><form method="post" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?=LANGUAGE_ID?>">
	<?=bitrix_sessid_post()?>
	<?$tabControl->BeginNextTab();?>
		<?
		if (is_array($arDisplayOptions)):
			foreach($arDisplayOptions as $Option):
			$val = COption::GetOptionString($module_id, $Option[0]);

			$type = $Option[2];
		?>
		<tr>
			<td valign="top" width="50%"><?if($type[0]=="checkbox")
								echo "<label for=\"".htmlspecialcharsbx($Option[0])."\">".$Option[1]."</label>";
							else
								echo $Option[1];?></td>
			<td valign="top" width="50%"><?
			if($type[0]=="checkbox"):
				?><input type="checkbox" name="<?echo htmlspecialcharsbx($Option[0])?>" id="<?echo htmlspecialcharsbx($Option[0])?>" value="Y"<?if($val=="Y")echo" checked";?>><?
			elseif($type[0]=="text"):
				?><input type="text" size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialcharsbx($val)?>" name="<?echo htmlspecialcharsbx($Option[0])?>"><?
			elseif($type[0]=="textarea"):
				?><textarea rows="<?echo $type[1]?>" cols="<?echo $type[2]?>" name="<?echo htmlspecialcharsbx($Option[0])?>"><?echo htmlspecialcharsbx($val)?></textarea><?
			endif;
			?></td>
		</tr>
		<?
			endforeach;
		endif;
		?>

	<?$tabControl->BeginNextTab();?>
	<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");?>
	<?$tabControl->Buttons();?>
	<script language="JavaScript">
	function RestoreDefaults()
	{
		if(confirm('<?echo AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>'))
			window.location = "<?echo $APPLICATION->GetCurPage()?>?RestoreDefaults=Y&lang=<?=LANGUAGE_ID?>&mid=<?echo urlencode($mid)?>";
	}
	</script>
	<input <?if ($VOTE_RIGHT<"W") echo "disabled" ?> type="submit" name="Update" value="<?=GetMessage("VOTE_SAVE")?>">
	<input type="hidden" name="Update" value="Y">
	<input type="reset" name="reset" value="<?=GetMessage("VOTE_RESET")?>">
	<input <?if ($VOTE_RIGHT<"W") echo "disabled" ?> type="button" title="<?echo GetMessage("MAIN_HINT_RESTORE_DEFAULTS")?>" OnClick="RestoreDefaults();" value="<?echo GetMessage("MAIN_RESTORE_DEFAULTS")?>">
	<?$tabControl->End();?>
	</form>
<?
}
*/
?>
