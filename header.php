<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
$CurDir = $APPLICATION->GetCurDir();
$CurUri = $APPLICATION->GetCurUri();
?>

<!doctype html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
    <?
    use Bitrix\Main\Page\Asset;

    // JS
    CJSCore::Init(array("jquery3"));
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/fancy/jquery.fancybox.min.js');
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/myscripts.min.js');
    // CSS
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/boostrap.min.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/js/fancy/jquery.fancybox.min.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/fonts/Arial/stylesheet.min.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/fonts/fontAwesome/font-awesome.min.css');
    
    // Добавляем FontAwesome из CDN как резерв
    Asset::getInstance()->addString('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">');

    // Обновленные стили для header
    Asset::getInstance()->addString('
    <style>
      body{margin: 0; font-family: Arial, sans-serif;}
      
      .custom-header{
        border-bottom: 1px solid #ddd; 
        position: relative; 
        z-index: 1000; 
        background: white;
        padding: 0 20px;
      }
      
      .header-container{
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px;
        position: relative;
      }
      
      .header-top{
        display: flex; 
        align-items: center; 
        justify-content: space-between;
        padding: 20px 0;
      }
      
      .logo img{height: 60px;}
      
      .header-actions{
        display: flex; 
        gap: 20px;
        margin-left: auto;
      }
      
      .header-actions a{ 
        text-decoration: none; 
        font-weight: 600; 
        font-size: 14px; 
        color: #333; 
        padding: 10px 20px;
        border-radius: 6px; 
        transition: background-color 0.3s, color 0.3s;
      }
      
      .header-actions a:hover{
        background-color: #120fa0; 
        color: #fff;
      }
      
      /* Стили для иконок */
      .header-icons {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-left: 20px;
      }
      
      .header-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f8f9fa;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid transparent;
      }
      
      .header-icon:hover {
        background: #120fa0;
        color: #fff;
        border-color: #120fa0;
        transform: translateY(-2px);
      }
      
      .header-icon i {
        font-size: 18px;
      }
      
      .header-icon.profile-icon {
        background: #e3f2fd;
        color: #1976d2;
      }
      
      .header-icon.profile-icon:hover {
        background: #1976d2;
        color: #fff;
      }
      
      .header-icon.cart-icon {
        background: #f3e5f5;
        color: #7b1fa2;
        position: relative;
      }
      
      .header-icon.cart-icon:hover {
        background: #7b1fa2;
        color: #fff;
      }
      
      .header-icon.telegram-icon {
        background: #e3f2fd;
        color: #0088cc;
      }
      
      .header-icon.telegram-icon:hover {
        background: #0088cc;
        color: #fff;
      }
      
      .header-icon.whatsapp-icon {
        background: #e8f5e8;
        color: #25d366;
      }
      
      .header-icon.whatsapp-icon:hover {
        background: #25d366;
        color: #fff;
      }
      
      /* Счетчик товаров в корзине */
      .cart-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ff4444;
        color: #fff;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 11px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 18px;
      }
      
      .header-bottom{
        padding: 0; 
        position: relative; 
        background: white; 
        z-index: 1000;
      }
      
      .catalog-menu{position: static;}
      
      .main-menu{
        display: flex; 
        background: #fff; 
        padding: 0; 
        margin: 0; 
        list-style: none; 
        border-bottom: 2px solid #e0e0e0;
        justify-content: flex-start;
        gap: 0;
        align-items: center;
      }
      
      .main-menu > li{
        position: relative;
        order: 1; /* Все остальные элементы после кнопки каталог */
      }
      
      .main-menu > li.catalog-menu-item{
        order: -1 !important; /* Кнопка каталог всегда первая */
      }
      
      .main-menu > li > a{
        display: block; 
        color: #222; 
        font-weight: bold; 
        padding: 20px 30px;
        text-decoration: none; 
        transition: background 0.2s, color 0.2s;
        white-space: nowrap;
      }
      
      .main-menu > li > button{
        display: block; 
        color: #222; 
        font-weight: bold; 
        padding: 20px 30px;
        text-decoration: none; 
        transition: background 0.2s, color 0.2s;
        white-space: nowrap;
        border: none;
        background: transparent;
        cursor: pointer;
        width: 100%;
      }
      
      .main-menu > li.has-megamenu > a:hover,
      .main-menu > li.has-megamenu.active > a{
        background: #120fa0; 
        color: #fff;
      }
      
      /* Стили для обычных пунктов меню с подменю */
      .main-menu > li.has-submenu {
        position: relative;
      }
      
      .main-menu > li.has-submenu > a {
        position: relative;
        transition: all 0.3s ease !important;
      }
      
      .main-menu > li.has-submenu > a:hover {
        background: #120fa0 !important;
        color: #fff !important;
      }
      
      /* Дополнительные стили для всех пунктов меню (кроме каталога) */
      .main-menu > li:not(.catalog-menu-item) > a {
        transition: all 0.3s ease !important;
      }
      
      .main-menu > li:not(.catalog-menu-item) > a:hover {
        background: #120fa0 !important;
        color: #fff !important;
      }
      
      /* Подменю для обычных пунктов */
      .main-menu > li.has-submenu .submenu {
        position: absolute;
        top: 100%;
        left: 0;
        background: #fff;
        min-width: 250px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        border-radius: 8px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1000;
        padding: 15px 0;
        margin-top: 5px;
      }
      
      .main-menu > li.has-submenu:hover .submenu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
      }
      
      .main-menu > li.has-submenu .submenu ul {
        list-style: none;
        margin: 0;
        padding: 0;
      }
      
      .main-menu > li.has-submenu .submenu li {
        margin: 0;
      }
      
      .main-menu > li.has-submenu .submenu a {
        display: block;
        padding: 12px 20px;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
      }
      
      .main-menu > li.has-submenu .submenu a:hover {
        background: #f8f9fa;
        color: #120fa0;
        border-left-color: #120fa0;
        padding-left: 25px;
      }
      
      /* Кнопка Каталог */
      .catalog-menu-item {
        position: relative;
        order: -1 !important; /* Принудительно ставим первым */
        margin-right: 0 !important;
      }
      
      /* Убеждаемся что кнопка каталог первая */
      .main-menu .catalog-menu-item {
        order: -1 !important;
      }
      
      .catalog-toggle-btn {
        display: flex !important;
        align-items: center;
        gap: 8px;
        background: #120fa0 !important;
        color: #fff !important;
        border: none;
        padding: 20px 30px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s;
        border-radius: 0;
        height: 100%;
        white-space: nowrap;
      }
      
      .catalog-toggle-btn:hover,
      .catalog-toggle-btn.active {
        background: #0e0d8a;
        color: #fff;
      }
      
      .catalog-toggle-btn span {
        font-weight: bold;
      }
      
      /* Гамбургер меню */
      .hamburger {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 20px;
        height: 16px;
        cursor: pointer;
      }
      
      .hamburger span {
        display: block;
        height: 2px;
        width: 100%;
        background: #fff;
        border-radius: 1px;
        transition: all 0.3s ease;
        transform-origin: center;
      }
      
      /* Анимация превращения в крестик */
      .catalog-toggle-btn.active .hamburger span:nth-child(1) {
        transform: rotate(45deg) translate(6px, 6px);
      }
      
      .catalog-toggle-btn.active .hamburger span:nth-child(2) {
        opacity: 0;
        transform: scaleX(0);
      }
      
      .catalog-toggle-btn.active .hamburger span:nth-child(3) {
        transform: rotate(-45deg) translate(6px, -6px);
      }
      
      /* Мегаменю - под header */
      .megamenu {
        display: none;
        position: fixed;
        left: 0;
        top: 100%; /* Прямо под header */
        width: 100vw;
        height: calc(100vh - 100%);
        background: #fff;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        z-index: 999; /* Ниже header */
        padding: 0;
        overflow: hidden;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.3s ease, transform 0.3s ease;
      }
      
      .megamenu.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
      }
      
      /* Оверлей для закрытия мегаменю */
      .megamenu-overlay {
        position: fixed;
        top: 100%; /* Начинается под header */
        left: 0;
        width: 100vw;
        height: calc(100vh - 100%);
        background: rgba(0,0,0,0.3);
        z-index: 998; /* Ниже мегаменю */
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease;
      }
      
      .megamenu-overlay.show {
        display: block;
        opacity: 1;
      }
      
      /* Сдвигаем основной контент при открытом мегаменю */
      body.megamenu-open {
        overflow: hidden;
      }
    </style>
    ');

    $APPLICATION->ShowHead();
    ?>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title><? $APPLICATION->ShowTitle() ?></title>
</head>
<body>
<?$APPLICATION->ShowPanel();?>

<header class="custom-header">
    <div class="header-container">
        <div class="header-top">
            <div class="logo">
                <a href="/"><img src="<?=SITE_TEMPLATE_PATH?>/img/Fitasyntex_logo_new_site.jpg" alt="Фитасинтекс логотип"></a>
            </div>

            <?$APPLICATION->IncludeComponent(
                    "bitrix:search.title",
                    "header_search",
                    array(
                            "NUM_CATEGORIES" => "1",
                            "TOP_COUNT" => "5",
                            "ORDER" => "date",
                            "USE_LANGUAGE_GUESS" => "Y",
                            "CHECK_DATES" => "N",
                            "SHOW_OTHERS" => "N",
                            "PAGE" => "#SITE_DIR#catalog/",
                            "CATEGORY_0_TITLE" => "",
                            "CATEGORY_0" => array("iblock_catalog"),
                            "SHOW_INPUT" => "Y",
                            "INPUT_ID" => "header-search-input",
                            "CONTAINER_ID" => "header-search",
                            "SHOW_PREVIEW" => "Y",
                            "PREVIEW_WIDTH" => 60,
                            "PREVIEW_HEIGHT" => 60,
                            "SHOW_PREVIEW_TEXT" => "N"
                    ),
                    false,
                    array("HIDE_ICONS" => "Y")
            );?>

            <div class="header-actions">
                <?if($USER->IsAuthorized()):?>
                    <a href="/personal/profile/"><?=$USER->GetFormattedName(false)?></a>
                    <a href="/?logout=yes">Выход</a>
                <?else:?>
                    <a href="/personal/profile/">Вход</a>
                    <a href="/auth/?register=yes">Регистрация</a>
                <?endif;?>
                <?if(CModule::IncludeModule("sale")):?>
                    <?$APPLICATION->IncludeComponent(
                            "bitrix:sale.basket.basket.line",
                            ".default",
                            array(
                                    "PATH_TO_BASKET" => "/personal/cart/",
                                    "PATH_TO_ORDER" => "/personal/order/",
                                    "SHOW_NUM_PRODUCTS" => "Y",
                                    "SHOW_TOTAL_PRICE" => "Y",
                                    "SHOW_PRODUCTS" => "N"
                            ),
                            false
                    );?>
                <?endif;?>
                
                <!-- Иконки -->
                <div class="header-icons">
                    <!-- Иконка профиля -->
                    <a href="/personal/profile/" class="header-icon profile-icon" title="Профиль">
                        <i class="fa fa-user">👤</i>
                    </a>
                    
                    <!-- Иконка корзины -->
                    <a href="/personal/cart/" class="header-icon cart-icon" title="Корзина">
                        <i class="fa fa-shopping-cart">🛒</i>
                        <span class="cart-count" id="cart-count">0</span>
                    </a>
                    
                    <!-- Иконка Телеграма -->
                    <a href="https://t.me/fitasyntex_official" target="_blank" class="header-icon telegram-icon" title="Написать в Telegram">
                        <i class="fa fa-telegram">📱</i>
                    </a>
                    
                    <!-- Иконка Ватсапа -->
                    <a href="https://wa.me/" target="_blank" class="header-icon whatsapp-icon" title="Написать в WhatsApp">
                        <i class="fa fa-whatsapp">💬</i>
                    </a>
                </div>
            </div>
        </div>

        <div class="header-bottom">
            <nav class="catalog-menu" aria-label="Меню сайта">
                <ul class="main-menu">
                    <!-- Кнопка Каталог - первая в меню -->
                    <li class="catalog-menu-item">
                        <button class="catalog-toggle-btn" id="catalog-toggle">
                            <span>Каталог</span>
                            <div class="hamburger">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </button>
                    </li>

                    <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "megamenu",
                            array(
                                    "ROOT_MENU_TYPE" => "main",
                                    "MENU_CACHE_TYPE" => "A",
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "MAX_LEVEL" => "3",
                                    "CHILD_MENU_TYPE" => "main",
                                    "USE_EXT" => "Y",
                                    "DELAY" => "N",
                                    "ALLOW_MULTI_SELECT" => "N"
                            ),
                            false
                    );?>
                </ul>
            </nav>
        </div>
    </div>
</header>

<!-- Оверлей для закрытия мегаменю -->
<div class="megamenu-overlay" id="megamenu-overlay"></div>

<!-- Мегаменю -->
<div class="megamenu" id="megamenu">
    <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "megamenu_unified",
            array(
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "4",
                    "SECTION_ID" => "",
                    "SECTION_CODE" => "",
                    "COUNT_ELEMENTS" => "N",
                    "TOP_DEPTH" => "3",
                    "SECTION_URL" => "/catalog/#SECTION_CODE#/",
                    "VIEW_MODE" => "LINE",
                    "SHOW_PARENT_NAME" => "N",
                    "SECTION_FIELDS" => array(),
                    "SECTION_USER_FIELDS" => array(),
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_GROUPS" => "Y"
            ),
            false
    );?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const catalogToggle = document.getElementById('catalog-toggle');
        const megamenu = document.getElementById('megamenu');
        const overlay = document.getElementById('megamenu-overlay');
        const body = document.body;
        const header = document.querySelector('.custom-header');

        if (catalogToggle && megamenu && overlay && header) {
            // Функция для обновления позиции мегаменю
            function updateMegamenuPosition() {
                const headerRect = header.getBoundingClientRect();
                const headerBottom = headerRect.bottom;

                megamenu.style.top = headerBottom + 'px';
                megamenu.style.left = '0';
                megamenu.style.width = '100vw';
                megamenu.style.height = 'calc(100vh - ' + headerBottom + 'px)';

                overlay.style.top = headerBottom + 'px';
                overlay.style.height = 'calc(100vh - ' + headerBottom + 'px)';
            }

            // Обновляем позицию при загрузке и изменении размера окна
            updateMegamenuPosition();
            window.addEventListener('resize', updateMegamenuPosition);

            // Открытие мегаменю
            catalogToggle.addEventListener('click', function(e) {
                e.stopPropagation();

                const isOpen = megamenu.classList.contains('show');

                if (!isOpen) {
                    // Обновляем позицию перед открытием
                    updateMegamenuPosition();

                    megamenu.classList.add('show');
                    overlay.classList.add('show');
                    catalogToggle.classList.add('active');

                    // Блокируем скролл страницы
                    body.classList.add('megamenu-open');

                    // Анимация прокрутки к началу мегаменю
                    setTimeout(() => {
                        megamenu.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }, 100);
                } else {
                    megamenu.classList.remove('show');
                    overlay.classList.remove('show');
                    catalogToggle.classList.remove('active');
                    body.classList.remove('megamenu-open');
                }
            });

            // Закрытие мегаменю по клику на оверлей
            overlay.addEventListener('click', function() {
                megamenu.classList.remove('show');
                overlay.classList.remove('show');
                catalogToggle.classList.remove('active');
                body.classList.remove('megamenu-open');
            });

            // Закрытие мегаменю по ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    megamenu.classList.remove('show');
                    overlay.classList.remove('show');
                    catalogToggle.classList.remove('active');
                    body.classList.remove('megamenu-open');
                }
            });
        } else {
            console.error('Не найдены элементы мегаменю:', {
                catalogToggle: !!catalogToggle,
                megamenu: !!megamenu,
                overlay: !!overlay,
                header: !!header
            });
        }
        
        // Обновление счетчика корзины
        function updateCartCount() {
            const cartCountElement = document.getElementById('cart-count');
            if (cartCountElement) {
                // Здесь можно добавить AJAX запрос для получения количества товаров в корзине
                // Пока оставляем статичное значение
                const cartCount = 0; // Замените на реальное количество из корзины
                cartCountElement.textContent = cartCount;
                cartCountElement.style.display = cartCount > 0 ? 'flex' : 'none';
            }
        }
        
        // Обновляем счетчик при загрузке страницы
        updateCartCount();
        
        // Обновляем счетчик каждые 30 секунд (опционально)
        setInterval(updateCartCount, 30000);
        
        // Отладочная информация
        console.log('Header icons loaded:', {
            headerIcons: !!document.querySelector('.header-icons'),
            profileIcon: !!document.querySelector('.profile-icon'),
            cartIcon: !!document.querySelector('.cart-icon'),
            telegramIcon: !!document.querySelector('.telegram-icon'),
            whatsappIcon: !!document.querySelector('.whatsapp-icon')
        });
    });
</script>
