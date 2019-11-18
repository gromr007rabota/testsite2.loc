<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("menuCatalogRazdel");
?>

<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.section.list",
    "section_list_menu_catalog",
    Array(
        "ADD_SECTIONS_CHAIN" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "COMPONENT_TEMPLATE" => "section_list_menu_catalog",
        "COUNT_ELEMENTS" => "Y",
        "FILTER_NAME" => "sectionsFilter",
        "IBLOCK_ID" => "2",
        "IBLOCK_TYPE" => "catalog",
        "SECTION_CODE" => "",
        "SECTION_FIELDS" => array(0=>"ID",1=>"CODE",2=>"XML_ID",3=>"NAME",4=>"SORT",5=>"DESCRIPTION",6=>"PICTURE",7=>"DETAIL_PICTURE",8=>"IBLOCK_TYPE_ID",9=>"IBLOCK_ID",10=>"IBLOCK_CODE",11=>"IBLOCK_EXTERNAL_ID",12=>"DATE_CREATE",13=>"CREATED_BY",14=>"TIMESTAMP_X",15=>"MODIFIED_BY",16=>"",),
        "SECTION_ID" => "",
        "SECTION_URL" => "#SITE_DIR#/catalog/#SECTION_CODE#/",
        "SECTION_USER_FIELDS" => array(0=>"UF_BROWSER_TITLE",1=>"UF_KEYWORDS",2=>"UF_META_DESCRIPTION",3=>"UF_BACKGROUND_IMAGE",4=>"",),
        "SHOW_PARENT_NAME" => "Y",
        "TOP_DEPTH" => "10",
        "VIEW_MODE" => "LIST"
    )
);?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>