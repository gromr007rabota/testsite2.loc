<?
/*
 * Это административный скрипт модуля показывается в админке по ссылке исходя из его названия
 * http://testsite1.loc/bitrix/admin/grom_mymoduleadmin.php
 *
 * */

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");


//require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/vote/prolog.php");
CModule::includeModule("grom.mymodule");
IncludeModuleLangFile(__FILE__);

$APPLICATION->SetTitle("Первая страница моего модуля");

require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

?>
Какой то текст
<?


require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");



?>
<?
/*

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$voteId = intval($request->getQuery("VOTE_ID"));
try
{
	$vote = \Bitrix\Vote\Vote::loadFromId($voteId);
	global $USER;
	if (!$vote->canRead($USER->GetID()))
		throw new \Bitrix\Main\ArgumentException(GetMessage("ACCESS_DENIED"), "Access denied.");
}
catch(Exception $e)
{
	require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
	ShowError($e->getMessage());
	require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
	die();
}



if ($vote->canEdit($USER->GetID()))
{
	$context = new CAdminContextMenu(array(
		array(
			"TEXT"	=> GetMessage("VOTE_BACK_TO_VOTE"),
			"ICON"	=> "btn_list",
			"LINK"	=> "/bitrix/admin/vote_edit.php?lang=".LANGUAGE_ID."&ID=".$voteId
		)
	));
	$context->Show();
}

$APPLICATION->IncludeComponent("bitrix:voting.result", "with_description", array(
	"VOTE_ID" => $voteId,
	"CACHE_TYPE" => "N",
	"VOTE_ALL_RESULTS" => 'Y'
	)
);
*/

?>
