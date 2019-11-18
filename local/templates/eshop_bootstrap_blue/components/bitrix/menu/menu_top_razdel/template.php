<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
function recursMenu($param) {
    $ret = '<li><a href="'.$param["LINK"].'">'.$param["TEXT"].'</a>';
    if ($param["CHILDREN"]) {
        $ret .= '<ul class="submenu">';
        foreach($param["CHILDREN"] as $param) {
            $ret .= recursMenu($param);
        }
        $ret .= '</ul>';
    }
    return $ret;
}
?>
    <nav>
        <ul class="topmenu">
            <?foreach($arResult as $param):?>
                <?=recursMenu($param);?>
            <?endforeach;?>
        </ul>
    </nav>
<?/*
    <nav>
        <ul class="topmenu">
            <?foreach($arResult as $param):?>
                <li><a href="<?=$param["LINK"]?>"><?=$param["TEXT"]?></a>
                    <?if ($param["CHILDREN"]):?>
                        <ul class="submenu">
                            <?foreach($param["CHILDREN"] as $param2):?>
                                <li><a href="<?=$param2["LINK"]?>"><?=$param2["TEXT"]?></a>
                                    <?if ($param2["CHILDREN"]):?>
                                        <ul class="submenu">
                                            <?foreach($param2["CHILDREN"] as $param3):?>
                                                <li><a href="<?=$param3["LINK"]?>"><?=$param3["TEXT"]?></a>
                                            <?endforeach;?>
                                        </ul>
                                    <?endif;?>
                                </li>
                            <?endforeach;?>
                        </ul>
                    <?endif;?>
                </li>
            <?endforeach;?>

            <li><a href="" class="active">Главная</a>
                <ul class="submenu">
                    <li><a href="">меню второго уровня</a></li>
                    <li><a href="" class="submenu-link">меню второго уровня</a>
                        <ul class="submenu">
                            <li><a href="">меню третьего уровня</a></li>
                            <li><a href="">меню третьего уровня</a></li>
                            <li><a href="">меню третьего уровня</a></li>
                        </ul>
                    </li>
                    <li><a href="">меню второго уровня</a></li>
                </ul>
            </li>
            <li><a href="">Компания</a></li>
            <li><a href="">Блог</a></li>
            <li><a href="">Контакты</a></li>

        </ul>
    </nav>
*/?>
<?
//print_r('EE<pre>');
//print_r($arResult); print_r('<br/>');
//print_r('</pre>');

?>

<?/*

<?if (!empty($arResult)):?>
<ul id="horizontal-multilevel-menu">

<?
$previousLevel = 0;
foreach($arResult as $arItem):?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a>
				<ul>
		<?else:?>
			<li<?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><a href="<?=$arItem["LINK"]?>" class="parent"><?=$arItem["TEXT"]?></a>
				<ul>
		<?endif?>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li<?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
			<?endif?>

		<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li><a href="" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?endif?>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
<div class="menu-clear-left"></div>
<?endif?>
*/?>