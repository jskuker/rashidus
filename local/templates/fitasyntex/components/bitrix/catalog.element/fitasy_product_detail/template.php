<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$APPLICATION->SetAdditionalCSS($templateFolder . "/style.css");
$APPLICATION->AddHeadScript($templateFolder . "/product.js");

$arItem = $arResult["ITEM"];
$productId = $arItem["ID"];
$name = $arItem["NAME"];
$price = $arItem["MIN_PRICE"]["PRINT_VALUE"] ?? '—';
$priceValue = $arItem["MIN_PRICE"]["VALUE"] ?? 0;
$article = $arItem["PROPERTIES"]["ARTNUMBER"]["VALUE"] ?? '';
$stock = $arItem["PROPERTIES"]["STOCK"]["VALUE"] ?? '';
$desc = $arItem["PREVIEW_TEXT"] ?? '';
$detailText = $arItem["DETAIL_TEXT"] ?? '';

// Получаем изображения
$images = [];
if ($arItem["DETAIL_PICTURE"]["SRC"]) {
    $images[] = $arItem["DETAIL_PICTURE"];
}
if (!empty($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) {
    foreach ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $photoId) {
        $photo = CFile::GetFileArray($photoId);
        if ($photo) {
            $images[] = $photo;
        }
    }
}

// Проверяем, есть ли товар в корзине
$isInCart = isset($_SESSION['CART'][$productId]) && $_SESSION['CART'][$productId] > 0;
$cartQuantity = $isInCart ? $_SESSION['CART'][$productId] : 0;
?>

<div class="product-detail">
    <div class="product-detail__container">
        <!-- Хлебные крошки -->
        <div class="product-breadcrumbs">
            <a href="/catalog/">Каталог</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current"><?= htmlspecialchars($name) ?></span>
        </div>

        <div class="product-detail__content">
            <!-- Галерея изображений -->
            <div class="product-gallery">
                <div class="product-gallery__main">
                    <?php if (!empty($images)): ?>
                        <img id="main-image" src="<?= $images[0]["SRC"] ?>" alt="<?= htmlspecialchars($name) ?>">
                    <?php else: ?>
                        <img id="main-image" src="/path/to/placeholder.png" alt="<?= htmlspecialchars($name) ?>">
                    <?php endif; ?>
                </div>
                
                <?php if (count($images) > 1): ?>
                    <div class="product-gallery__thumbs">
                        <?php foreach ($images as $index => $image): ?>
                            <div class="gallery-thumb<?= $index === 0 ? ' active' : '' ?>" data-src="<?= $image["SRC"] ?>">
                                <img src="<?= CFile::ResizeImageGet($image, ['width' => 80, 'height' => 80], BX_RESIZE_IMAGE_PROPORTIONAL, true)['src'] ?>" alt="<?= htmlspecialchars($name) ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Информация о товаре -->
            <div class="product-info">
                <h1 class="product-title"><?= htmlspecialchars($name) ?></h1>
                
                <div class="product-meta">
                    <?php if ($article): ?>
                        <div class="product-meta__item">
                            <span class="meta-label">Артикул:</span>
                            <span class="meta-value"><?= htmlspecialchars($article) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($stock): ?>
                        <div class="product-meta__item">
                            <span class="meta-label">Наличие:</span>
                            <span class="meta-value stock-available"><?= htmlspecialchars($stock) ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="product-price">
                    <span class="price-value"><?= $price ?></span>
                </div>

                <!-- Описание -->
                <?php if ($desc): ?>
                    <div class="product-description">
                        <h3>Описание</h3>
                        <div class="description-text"><?= $desc ?></div>
                    </div>
                <?php endif; ?>

                <!-- Управление корзиной -->
                <div class="product-cart-controls" data-product-id="<?= $productId ?>">
                    <?php if ($isInCart): ?>
                        <div class="cart-quantity-controls">
                            <button class="cart-btn cart-btn-minus" data-action="decrease" data-product-id="<?= $productId ?>">-</button>
                            <span class="cart-quantity" data-product-id="<?= $productId ?>"><?= $cartQuantity ?></span>
                            <button class="cart-btn cart-btn-plus" data-action="increase" data-product-id="<?= $productId ?>">+</button>
                        </div>
                    <?php else: ?>
                        <button class="product-add-to-cart cart-btn-add" data-product-id="<?= $productId ?>" data-price="<?= $priceValue ?>">
                            Добавить в корзину
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Характеристики -->
                <?php if (!empty($arItem["PROPERTIES"])): ?>
                    <div class="product-properties">
                        <h3>Характеристики</h3>
                        <div class="properties-list">
                            <?php foreach ($arItem["PROPERTIES"] as $propCode => $prop): ?>
                                <?php if ($prop["VALUE"] && !in_array($propCode, ['ARTNUMBER', 'STOCK', 'MORE_PHOTO'])): ?>
                                    <div class="property-item">
                                        <span class="property-name"><?= htmlspecialchars($prop["NAME"]) ?>:</span>
                                        <span class="property-value"><?= htmlspecialchars($prop["VALUE"]) ?></span>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Детальное описание -->
        <?php if ($detailText): ?>
            <div class="product-detail-text">
                <h2>Подробное описание</h2>
                <div class="detail-content"><?= $detailText ?></div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Уведомления -->
<div id="product-notifications" class="product-notifications"></div>
