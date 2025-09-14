<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$sectionMap = [
        'Гомеопатические комплексы' => 16,
        'Монопрепараты'             => 21,
        'Аптечки'                   => 27,
        'Косметические средства'    => 54,
        'Крема, гели, мази, масла'  => 37,
        'Серии'                     => 49,
        'Сиропы и капли'            => 40,
];
?>

<?php
if (isset($arResult) && is_array($arResult)) {
    $count = count($arResult);
    for ($key = 0; $key < $count; $key++) {
        $item = $arResult[$key];
        if ($item["DEPTH_LEVEL"] != 1) continue;

        // Пропускаем "Каталог" - он будет отдельной кнопкой
        if ($item["TEXT"] == "Каталог") continue;
        
        // Проверяем есть ли подпункты
        $hasSubmenu = false;
        $submenuItems = [];
        
        // Ищем подпункты для текущего элемента
        for ($i = $key + 1; $i < $count; $i++) {
            $subItem = $arResult[$i];
            if ($subItem["DEPTH_LEVEL"] == 2) {
                $hasSubmenu = true;
                $submenuItems[] = $subItem;
            } elseif ($subItem["DEPTH_LEVEL"] == 1) {
                break; // Дошли до следующего пункта первого уровня
            }
        }
        
        // Для тестирования - добавляем подменю к некоторым пунктам
        $testSubmenuItems = [
            "Изготовление на заказ" => [
                ["TEXT" => "Индивидуальные заказы", "LINK" => "/custom-orders/"],
                ["TEXT" => "Оптовые заказы", "LINK" => "/wholesale/"]
            ],
            "О компании" => [
                ["TEXT" => "История компании", "LINK" => "/about/history/"],
                ["TEXT" => "Наша команда", "LINK" => "/about/team/"],
                ["TEXT" => "Сертификаты", "LINK" => "/about/certificates/"]
            ]
        ];
        
        if (isset($testSubmenuItems[$item["TEXT"]])) {
            $hasSubmenu = true;
            $submenuItems = $testSubmenuItems[$item["TEXT"]];
        }
        ?>
        <!-- Обычные пункты меню -->
        <li class="<?=$hasSubmenu ? 'has-submenu' : ''?>" data-debug="<?=$hasSubmenu ? 'has-submenu' : 'no-submenu'?>">
            <a href="<?=$item["LINK"]?>"><?=$item["TEXT"]?></a>
            
            <?php if ($hasSubmenu && !empty($submenuItems)): ?>
                <div class="submenu">
                    <ul>
                        <?php foreach ($submenuItems as $subItem): ?>
                            <li>
                                <a href="<?=$subItem["LINK"]?>"><?=$subItem["TEXT"]?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </li>
        <?php
    }
}
?>
