<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Получаем основные разделы (уровень 1)
$mainSections = [];
$subSectionsMap = [];

if (isset($arResult['SECTIONS']) && is_array($arResult['SECTIONS'])) {
    foreach ($arResult['SECTIONS'] as $section) {
        if ($section['DEPTH_LEVEL'] == 1) {
            $mainSections[] = $section;
        } elseif ($section['DEPTH_LEVEL'] == 2 && $section['IBLOCK_SECTION_ID']) {
            $subSectionsMap[$section['IBLOCK_SECTION_ID']][] = $section;
        }
    }
}

// Сортируем разделы в нужном порядке
$sortedSections = [];
$sectionOrder = [
        'Монопрепараты' => 0,
        'Гомеопатические комплексы' => 1,
        'Аптечки' => 2,
        'Крема, гели, мази, масла' => 3,
        'Сиропы, капли' => 4,
        'Серии' => 5,
        'Косметика' => 6,
        'Акции' => 7, // Акции в самом низу
];

// Сортируем по заданному порядку
usort($mainSections, function($a, $b) use ($sectionOrder) {
    $orderA = isset($sectionOrder[$a['NAME']]) ? $sectionOrder[$a['NAME']] : 999;
    $orderB = isset($sectionOrder[$b['NAME']]) ? $sectionOrder[$b['NAME']] : 999;
    return $orderA - $orderB;
});

// ID разделов для правых колонок (можно настроить через параметры)
$rightColumnSectionIds = [68, 70, 71, 72]; // Пока оставляем как есть, потом адаптируем
?>

<style>
    /* Стили для контента мегаменю - убираем конфликт с .megamenu из header */
    .mega-menu-content {
        display: flex;
        width: 100%;
        height: 100%;
        background: #fff;
        box-sizing: border-box;
        padding: 0;
        overflow: hidden;
    }

    /* Левая колонка с основными разделами */
    .mega-menu-columns {
        flex: 0 0 280px;
        background: #f8f9fa;
        padding: 30px 15px;
        margin-left: 0; /* Убираем отступ - выравниваем точно под кнопкой каталог */
        box-sizing: border-box;
        overflow-y: auto;
        border-right: 1px solid #e9ecef;
    }

    .mega-menu-columns ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .mega-menu-columns ul li {
        margin-bottom: 6px;
        position: relative;
        cursor: pointer;
        padding: 15px 18px;
        font-weight: 600;
        color: #120fa0;
        border-radius: 6px;
        transition: background 0.2s, color 0.2s;
        font-size: 15px;
    }

    .mega-menu-columns ul li.active,
    .mega-menu-columns ul li:hover {
        background-color: #120fa0;
        color: #fff;
    }

    .mega-menu-columns ul li.active a,
    .mega-menu-columns ul li:hover a {
        color: #fff;
    }

    .mega-menu-columns ul li a {
        color: inherit;
        text-decoration: none;
        display: block;
        width: 100%;
        font-weight: 700;
        transition: color 0.2s;
    }

    /* Правая область с контентом */
    .sub-submenu-container-list {
        flex: 1;
        position: relative;
        background: #fff;
        padding: 0;
        display: flex;
        align-items: flex-start;
        box-sizing: border-box;
        overflow: hidden;
    }

    .sub-submenu-container {
        display: none;
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0; top: 0; right: 0; bottom: 0;
        background: #fff;
        transition: opacity 0.2s;
        opacity: 0;
        z-index: 1;
        box-sizing: border-box;
        overflow: hidden;
    }

    .sub-submenu-container.active {
        display: block;
        opacity: 1;
        z-index: 2;
    }

    /* Заголовок раздела */
    .mega-menu-header {
        text-align: center;
        margin-bottom: 30px;
        padding: 30px 50px 0 50px;
    }

    .mega-menu-title {
        font-size: 2rem;
        font-weight: bold;
        color: #222;
        border-bottom: 2px solid #120fa0;
        display: inline-block;
        padding-bottom: 8px;
        margin-bottom: 0;
    }

    /* Сетка с подразделами */
    .mega-menu-flex {
        display: flex;
        gap: 60px;
        align-items: flex-start;
        padding: 0 50px 50px 50px;
        height: calc(100% - 100px);
        box-sizing: border-box;
    }

    .mega-menu-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(160px, 1fr));
        gap: 25px 20px;
        justify-items: center;
        min-width: 1000px;
        max-width: 1200px;
        min-height: 500px;
        max-height: 600px;
        overflow-y: auto;
        padding: 15px 0;
    }

    .mega-menu-grid-item {
        text-align: center;
        min-height: 160px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .mega-menu-grid-img {
        width: 100px;
        height: 100px;
        background: #f2f2f2;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px auto;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }

    .mega-menu-grid-img img {
        max-width: 100%;
        max-height: 100%;
        display: block;
    }

    .mega-menu-grid-img-placeholder {
        width: 100%;
        height: 100%;
        background: #eaeaea;
        border-radius: 12px;
    }

    .mega-menu-grid-title {
        font-size: 1rem;
        color: #222;
        font-weight: 500;
        margin-top: 6px;
        word-break: normal;
        white-space: normal;
        line-height: 1.2;
        flex-shrink: 0;
        min-height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mega-menu-grid-item a {
        text-decoration: none;
        color: inherit;
        display: block;
        transition: color 0.2s;
    }

    .mega-menu-grid-item a:hover .mega-menu-grid-title {
        color: #120fa0;
    }

    /* Правые колонки */
    .mega-menu-categories {
        display: flex;
        flex: 1;
        gap: 50px;
        align-items: flex-start;
        overflow-y: auto;
    }

    .mega-menu-category-col {
        min-width: 200px;
    }

    .mega-menu-category-title {
        font-weight: bold;
        margin-bottom: 18px;
        font-size: 1.2rem;
        color: #120fa0;
    }

    .mega-menu-category-col ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .mega-menu-category-col li {
        margin-bottom: 12px;
    }

    .mega-menu-category-col a {
        color: #120fa0;
        text-decoration: none;
        transition: color 0.2s;
        font-size: 1rem;
        padding: 6px 0;
        display: block;
    }

    .mega-menu-category-col a:hover {
        color: #222;
    }

    .empty-sub {
        color: #aaa;
        font-style: italic;
    }

    /* Скроллбар */
    .mega-menu-columns::-webkit-scrollbar,
    .mega-menu-grid::-webkit-scrollbar,
    .mega-menu-categories::-webkit-scrollbar {
        width: 8px;
    }

    .mega-menu-columns::-webkit-scrollbar-track,
    .mega-menu-grid::-webkit-scrollbar-track,
    .mega-menu-categories::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .mega-menu-columns::-webkit-scrollbar-thumb,
    .mega-menu-grid::-webkit-scrollbar-thumb,
    .mega-menu-categories::-webkit-scrollbar-thumb {
        background: #120fa0;
        border-radius: 4px;
    }
</style>

<!-- Убираем конфликтующий div с классом mega-menu, оставляем только контент -->
<div class="mega-menu-content">
    <!-- Левая колонка с основными разделами -->
    <div class="mega-menu-columns">
        <ul>
            <?php foreach ($mainSections as $i => $section): ?>
                <li data-section="<?=$section['ID']?>" class="<?=$i === 0 ? 'active' : ''?>">
                    <a href="<?=$section['SECTION_PAGE_URL']?>"><?=$section['NAME']?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Правая область с контентом -->
    <div class="sub-submenu-container-list">
        <?php foreach ($mainSections as $i => $section): ?>
            <div class="sub-submenu-container<?=$i === 0 ? ' active' : ''?>" data-section="<?=$section['ID']?>">
                <!-- Заголовок раздела -->
                <div class="mega-menu-header">
                    <span class="mega-menu-title"><?=htmlspecialchars($section['NAME'])?></span>
                </div>

                <!-- Контент раздела -->
                <div class="mega-menu-flex">
                    <!-- Сетка с подразделами -->
                    <div class="mega-menu-grid">
                        <?php
                        $subSections = $subSectionsMap[$section['ID']] ?? [];
                        $gridSections = array_filter($subSections, function($sub) use ($rightColumnSectionIds) {
                            return !in_array($sub['ID'], $rightColumnSectionIds);
                        });
                        ?>

                        <?php if (!empty($gridSections)): ?>
                            <?php foreach ($gridSections as $sub): ?>
                                <?php
                                $subImg = '';
                                if (!empty($sub['UF_MENU_IMAGE'])) {
                                    $subImg = CFile::GetPath($sub['UF_MENU_IMAGE']);
                                }
                                ?>
                                <div class="mega-menu-grid-item">
                                    <a href="<?=$sub['SECTION_PAGE_URL']?>">
                                        <div class="mega-menu-grid-img">
                                            <?php if ($subImg): ?>
                                                <img src="<?=$subImg?>" alt="<?=htmlspecialchars($sub['NAME'])?>" />
                                            <?php else: ?>
                                                <div class="mega-menu-grid-img-placeholder"></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mega-menu-grid-title"><?=htmlspecialchars($sub['NAME'])?></div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="mega-menu-grid-item">
                                <span class="empty-sub">Нет подразделов</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Правые колонки -->
                    <div class="mega-menu-categories">
                        <?php
                        $categoryColumns = [];
                        foreach ($subSections as $sub) {
                            if (in_array($sub['ID'], $rightColumnSectionIds)) {
                                $categoryColumns[$sub['ID']] = [
                                        'NAME' => $sub['NAME'],
                                        'SECTION_PAGE_URL' => $sub['SECTION_PAGE_URL'],
                                        'ITEMS' => []
                                ];
                            }
                        }

                        // Получаем элементы 3-го уровня для правых колонок
                        if (isset($arResult['SECTIONS']) && is_array($arResult['SECTIONS'])) {
                            foreach ($arResult['SECTIONS'] as $item) {
                                if ($item['DEPTH_LEVEL'] == 3 && isset($categoryColumns[$item['IBLOCK_SECTION_ID']])) {
                                    $categoryColumns[$item['IBLOCK_SECTION_ID']]['ITEMS'][] = $item;
                                }
                            }
                        }
                        ?>

                        <?php foreach ($categoryColumns as $cat): ?>
                            <div class="mega-menu-category-col">
                                <div class="mega-menu-category-title">
                                    <a href="<?=$cat['SECTION_PAGE_URL']?>"><?=htmlspecialchars($cat['NAME'])?></a>
                                </div>
                                <ul>
                                    <?php if (!empty($cat['ITEMS'])): ?>
                                        <?php foreach ($cat['ITEMS'] as $item): ?>
                                            <li><a href="<?=$item['SECTION_PAGE_URL']?>"><?=htmlspecialchars($item['NAME'])?></a></li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li><span class="empty-sub">Нет подразделов</span></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuLinks = document.querySelectorAll('.mega-menu-columns ul li');
        const submenus = document.querySelectorAll('.sub-submenu-container');

        menuLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                // Убираем активный класс со всех элементов
                menuLinks.forEach(l => l.classList.remove('active'));
                submenus.forEach(s => s.classList.remove('active'));

                // Добавляем активный класс к текущему элементу
                link.classList.add('active');

                // Показываем соответствующий контент
                const sectionId = link.getAttribute('data-section');
                const submenu = document.querySelector('.sub-submenu-container[data-section="' + sectionId + '"]');
                if (submenu) submenu.classList.add('active');
            });
        });
    });
</script>
