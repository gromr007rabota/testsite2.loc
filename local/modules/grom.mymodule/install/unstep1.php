<?
use \Bitrix\Main\Localization\Loc;

if(!check_bitrix_sessid())
    return;

Loc::loadMessages(__FILE__);
?>
<form action="<?echo $APPLICATION->GetCurPage()?>">
<?=bitrix_sessid_post()?>
	<input type="hidden" name="lang" value="<?=LANGUAGE_ID?>" />
	<input type="hidden" name="id" value="grom.mymodule" />
	<input type="hidden" name="uninstall" value="Y" />
	<input type="hidden" name="step" value="2" />
	<?echo CAdminMessage::ShowMessage(Loc::getMessage("MOD_UNINST_WARN"))?>
	<p><?=Loc::getMessage("MOD_UNINST_SAVE")?></p>
	<p>
		<input type="checkbox" name="savedata" id="savedata" value="Y" checked="checked" />
		<label for="savedata"><?=Loc::getMessage("MOD_UNINST_SAVE_TABLES")?></label>
	</p>
	<input type="submit" name="inst" value="<?=Loc::getMessage("MOD_UNINST_DEL")?>" />
</form>
<?//Кнопка возврата на список модулей?>
    <form action="<?echo $APPLICATION->GetCurPage()?>">
        <input type="hidden" name="lang" value="<?=LANGUAGE_ID?>" />
        <input type="submit" name="" value="<?=Loc::getMessage("MOD_BACK")?>" />
    </form>
<?