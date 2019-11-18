<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;
$aMenuLinksExt = array();


if(CModule::IncludeModule('iblock'))
{
	$arFilter = array(
		"TYPE" => "catalog",
		"SITE_ID" => SITE_ID,
	);

	$dbIBlock = CIBlock::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), $arFilter);
	$dbIBlock = new CIBlockResult($dbIBlock);

	if ($arIBlock = $dbIBlock->GetNext())
	{
		if(defined("BX_COMP_MANAGED_CACHE"))
			$GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_".$arIBlock["ID"]);

		if($arIBlock["ACTIVE"] == "Y")
		{

            $aMenuLinksExt = $APPLICATION->IncludeComponent(
                "bitrix:menu.sections",
                "",
                array(
                    "IS_SEF" => "Y",
                    "SEF_BASE_URL" => "",
                    "SECTION_PAGE_URL" => "",
                    "DETAIL_PAGE_URL" => "",
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "2",
                    "DEPTH_LEVEL" => "3",
                    "CACHE_TYPE" => "N",
                    "CACHE_TIME" => "36000000"
                ),
                false,
                array(
                    "HIDE_ICONS" => "N"
                )
            );


        }
	}

	if(defined("BX_COMP_MANAGED_CACHE"))
		$GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_new");
}



$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);

?>