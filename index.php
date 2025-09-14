<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("");
?><?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"mainslider", 
	array(
		"COMPONENT_TEMPLATE" => "mainslider",
		"IBLOCK_TYPE" => "banners",
		"IBLOCK_ID" => "5",
		"NEWS_COUNT" => "2",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "SLIDER_ABOUT",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"STRICT_SECTION_CHECK" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?><?php

$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "news_scroll",
    array(
        "IBLOCK_TYPE" => "news",
        "IBLOCK_ID" => "9",
        "NEWS_COUNT" => "10",
        "SORT_BY1" => "PROPERTY_NEWS_DATA", // сортировка по дате из свойства
        "SORT_ORDER1" => "DESC",            // новые первыми
        "PROPERTY_CODE" => array("NEWS_IMG", "NEWS_DATA", "NEWS_TEXT"),
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "SET_TITLE" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "INCLUDE_SUBSECTIONS" => "Y",
        "FILTER_NAME" => "",
        "FIELD_CODE" => array("NAME", "DETAIL_PAGE_URL"),
        "CHECK_DATES" => "Y",
    ),
    false
);

$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "kursi", // Имя шаблона, который ты только что создал
    array(
        "IBLOCK_TYPE" => "kursi", // Тип инфоблока (замени на свой, если отличается)
        "IBLOCK_ID" => "10", // Укажи реальный ID инфоблока "Курсы"
        "NEWS_COUNT" => "20",
        "SORT_BY1" => "SORT",
        "SORT_ORDER1" => "ASC",
        "PROPERTY_CODE" => array("NAME_KURS", "IMG_KURS", "VID_KURS", "TEXT_KURS", "LINK_KURS"),
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "SET_TITLE" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "INCLUDE_SUBSECTIONS" => "Y",
        "FILTER_NAME" => "",
        "FIELD_CODE" => array("NAME", "DETAIL_PAGE_URL"),
        "CHECK_DATES" => "Y",
    ),
    false
);


?>
    <div class="about-block">
        <div class="about-block-img">
            <img src="/local/templates/fitasyntex/img/slider-managemnet1.png" alt="25 лет заботимся о вашем здоровье">
        </div>
        <div class="about-block-text">
            <div class="about-block-title">
                <b>25 лет</b> заботимся о Вашем здоровье
            </div>
            <div class="about-block-desc">
                ООО ПФК "Фитасинтекс" представляет высокоэффективные комплексные средства. Их эффективность обусловлена строгим соблюдением технологий изготовления лекарств, оптимально подобранным количественным и качественным составом действующих веществ, использованием в изготовлении высококачественного сырья.
            </div>
        </div>
    </div>
<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
