<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$APPLICATION->SetAdditionalCSS($templateFolder . "/style.css");
$APPLICATION->AddHeadScript($templateFolder . "/catalog.js");

$view = $_GET['view'] ?? 'grid'; // grid, large, list
$sort = $_GET['sort'] ?? 'popularity';

$icons = [
    'grid' => '<svg viewBox="0 0 24 24"><g fill="currentColor"><rect x="3" y="3" width="4" height="4"/><rect x="10" y="3" width="4" height="4"/><rect x="17" y="3" width="4" height="4"/><rect x="3" y="10" width="4" height="4"/><rect x="10" y="10" width="4" height="4"/><rect x="17" y="10" width="4" height="4"/><rect x="3" y="17" width="4" height="4"/><rect x="10" y="17" width="4" height="4"/><rect x="17" y="17" width="4" height="4"/></g></svg>',
    'large' => '<svg viewBox="0 0 24 24"><g fill="currentColor"><rect x="4" y="7" width="16" height="3"/><rect x="4" y="14" width="16" height="3"/></g></svg>',
    'list' => '<svg viewBox="0 0 24 24"><g fill="currentColor"><rect x="4" y="6" width="16" height="2"/><rect x="4" y="11" width="16" height="2"/><rect x="4" y="16" width="16" height="2"/></g></svg>',
];

// Получаем количество товаров в корзине
$cartCount = 0;
if (isset($_SESSION['CART'])) {
    $cartCount = array_sum($_SESSION['CART']);
}
?>

<div class="catalog-container">
    <!-- Индикатор корзины -->
    <div class="cart-indicator" id="cart-indicator">
        <a href="/cart/" class="cart-link">
            <svg viewBox="0 0 24 24" width="24" height="24">
                <path fill="currentColor" d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
            </svg>
            <span class="cart-count" id="cart-count"><?= $cartCount ?></span>
        </a>
    </div>

    <div class="catalog-controls">
        <div class="catalog-sort">
            <button class="sort-btn<?= $sort == 'popularity' ? ' active' : '' ?>" data-sort="popularity">По популярности</button>
            <button class="sort-btn<?= $sort == 'name' ? ' active' : '' ?>" data-sort="name">По алфавиту</button>
            <button class="sort-btn<?= $sort == 'price' ? ' active' : '' ?>" data-sort="price">По цене</button>
        </div>
        <div class="catalog-view-switch">
            <button class="view-btn<?= $view == 'grid' ? ' active' : '' ?>" data-view="grid" title="Плитка"><?= $icons['grid'] ?></button>
            <button class="view-btn<?= $view == 'large' ? ' active' : '' ?>" data-view="large" title="Крупный список"><?= $icons['large'] ?></button>
            <button class="view-btn<?= $view == 'list' ? ' active' : '' ?>" data-view="list" title="Компактный список"><?= $icons['list'] ?></button>
        </div>
    </div>
    
    <div class="catalog-items catalog-items-<?= $view ?> fade">
        <?php foreach ($arResult["ITEMS"] as $arItem): ?>
            <?php
            $img = $arItem["PREVIEW_PICTURE"]["SRC"] ?? '/path/to/placeholder.png';
            $name = $arItem["NAME"];
            $price = $arItem["MIN_PRICE"]["PRINT_VALUE"] ?? '—';
            $priceValue = $arItem["MIN_PRICE"]["VALUE"] ?? 0;
            $article = $arItem["PROPERTIES"]["ARTNUMBER"]["VALUE"] ?? '';
            $stock = $arItem["PROPERTIES"]["STOCK"]["VALUE"] ?? '';
            $desc = $arItem["PREVIEW_TEXT"] ?? '';
            $productId = $arItem["ID"];
            $isInCart = isset($_SESSION['CART'][$productId]) && $_SESSION['CART'][$productId] > 0;
            ?>
            <?php if ($view == 'grid'): ?>
                <div class="catalog-item" data-product-id="<?= $productId ?>">
                    <div class="catalog-item__img">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($name) ?>">
                    </div>
                    <div class="catalog-item__info">
                        <div class="catalog-item__title"><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?= htmlspecialchars($name) ?></a></div>
                        <div class="catalog-item__stock"><?= $stock ?></div>
                        <div class="catalog-item__article">Артикул: <?= $article ?></div>
                    </div>
                    <div class="catalog-item__price"><?= $price ?></div>
                    <div class="catalog-item__cart-controls">
                        <?php if ($isInCart): ?>
                            <div class="cart-quantity-controls">
                                <button class="cart-btn cart-btn-minus" data-action="decrease" data-product-id="<?= $productId ?>">-</button>
                                <span class="cart-quantity" data-product-id="<?= $productId ?>"><?= $_SESSION['CART'][$productId] ?></span>
                                <button class="cart-btn cart-btn-plus" data-action="increase" data-product-id="<?= $productId ?>">+</button>
                            </div>
                        <?php else: ?>
                            <button class="catalog-item__btn cart-btn-add" data-product-id="<?= $productId ?>" data-price="<?= $priceValue ?>">В корзину</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif ($view == 'large'): ?>
                <div class="catalog-item catalog-item-large" data-product-id="<?= $productId ?>">
                    <div class="catalog-item__img">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($name) ?>">
                    </div>
                    <div class="catalog-item__info">
                        <div class="catalog-item__title"><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?= htmlspecialchars($name) ?></a></div>
                        <div class="catalog-item__row">
                            <div class="catalog-item__stock"><?= $stock ?></div>
                            <div class="catalog-item__article">Артикул: <?= $article ?></div>
                        </div>
                        <?php if ($desc): ?>
                            <div class="catalog-item__desc">
                                <span class="catalog-item__desc-title">Характеристики</span>
                                <span class="catalog-item__desc-text"><?= htmlspecialchars($desc) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="catalog-item__price"><?= $price ?></div>
                    <div class="catalog-item__cart-controls">
                        <?php if ($isInCart): ?>
                            <div class="cart-quantity-controls">
                                <button class="cart-btn cart-btn-minus" data-action="decrease" data-product-id="<?= $productId ?>">-</button>
                                <span class="cart-quantity" data-product-id="<?= $productId ?>"><?= $_SESSION['CART'][$productId] ?></span>
                                <button class="cart-btn cart-btn-plus" data-action="increase" data-product-id="<?= $productId ?>">+</button>
                            </div>
                        <?php else: ?>
                            <button class="catalog-item__btn cart-btn-add" data-product-id="<?= $productId ?>" data-price="<?= $priceValue ?>">В корзину</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: // list ?>
                <div class="catalog-item catalog-item-list" data-product-id="<?= $productId ?>">
                    <div class="catalog-item__img">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($name) ?>">
                    </div>
                    <div class="catalog-item__price"><?= $price ?></div>
                    <div class="catalog-item__info">
                        <div class="catalog-item__title"><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?= htmlspecialchars($name) ?></a></div>
                        <div class="catalog-item__row">
                            <div class="catalog-item__stock"><?= $stock ?></div>
                            <div class="catalog-item__article">Артикул: <?= $article ?></div>
                        </div>
                    </div>
                    <div class="catalog-item__cart-controls">
                        <?php if ($isInCart): ?>
                            <div class="cart-quantity-controls">
                                <button class="cart-btn cart-btn-minus" data-action="decrease" data-product-id="<?= $productId ?>">-</button>
                                <span class="cart-quantity" data-product-id="<?= $productId ?>"><?= $_SESSION['CART'][$productId] ?></span>
                                <button class="cart-btn cart-btn-plus" data-action="increase" data-product-id="<?= $productId ?>">+</button>
                            </div>
                        <?php else: ?>
                            <button class="catalog-item__btn cart-btn-add" data-product-id="<?= $productId ?>" data-price="<?= $priceValue ?>">В корзину</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
        <div class="catalog-pager"><?= $arResult["NAV_STRING"] ?></div>
    <?php endif; ?>
</div>

<!-- Уведомления -->
<div id="cart-notifications" class="cart-notifications"></div>
