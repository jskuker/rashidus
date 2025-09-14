<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<style>
.main-slider {
  width: 100%;
  max-width: 1300px;   /* Сделали шире */
  min-width: 900px;    /* Можно убрать, если не нужно */
  margin: 0 auto;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 24px rgba(0,0,0,0.1);
}

.swiper-slide {
  display: flex !important;
  flex-direction: row !important;
  width: 1300px;      /* Фиксированная ширина */
  height: 400px;      /* Фиксированная высота */
}

.slide-img {
  flex: 1 1 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff;
  min-height: 400px;
  min-width: 0;
  height: 400px;
  width: 50%;
  overflow: hidden;
}

.slide-img {
  flex: 1 1 50%;
  min-width: 0;
  min-height: 400px;
  height: 400px;
  width: 50%;
  background: #fff;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover; /* Картинка всегда на всю область */
  display: block;
}

.slide-info {
  flex: 1 1 50%;
  background: rgba(18, 15, 160, 0.95);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px 32px;
  height: 400px;
  width: 50%;
}

.slide-content {
  max-width: 400px;
  width: 100%;
  text-align: center;
}

.slide-content h2 {
  font-size: 2rem;
  margin-bottom: 20px;
  font-weight: bold;
}

.slide-content p {
  font-size: 1.1rem;
  margin-bottom: 30px;
  word-break: break-word;
}

.slide-btn {
  display: inline-block;
  background: #fff;
  color: #120fa0;
  border: none;
  padding: 12px 32px;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: bold;
  text-decoration: none;
  transition: background 0.2s, color 0.2s;
  margin-top: 10px;
}

.slide-btn:hover {
  background: #FFFFFF;
  color: #120fa0;
}

/* Белые стрелки Swiper */
.swiper-button-next,
.swiper-button-prev {
  color: #fff !important;
  stroke: #fff !important;
  fill: #fff !important;
}

.slide-img {
  flex: 1 1 50%;
  min-width: 0;
  min-height: 400px !important;
  height: 400px !important;
  max-height: 400px !important;
  width: 50%;
  background: #fff;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  display: block;
}
.swiper-slide {
  display: flex !important;
  flex-direction: row !important;
  width: 1300px;
  height: 400px !important;
  min-height: 400px !important;
  max-height: 400px !important;
  overflow: hidden;
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<div class="swiper main-slider">
    <div class="swiper-wrapper">
        <?foreach($arResult["ITEMS"] as $item):?>
            <?php
            $img = '';
            if (!empty($item['PROPERTIES']['SLIDER_IMG']['VALUE'])) {
                $img = CFile::GetPath($item['PROPERTIES']['SLIDER_IMG']['VALUE']);
            }
            $about = '';
            if (!empty($item['PROPERTIES']['SLIDER_ABOUT']['~VALUE']['TEXT'])) {
                $about = $item['PROPERTIES']['SLIDER_ABOUT']['~VALUE']['TEXT'];
            } elseif (!empty($item['PROPERTIES']['SLIDER_ABOUT']['VALUE']['TEXT'])) {
                $about = $item['PROPERTIES']['SLIDER_ABOUT']['VALUE']['TEXT'];
            } elseif (!empty($item['PROPERTIES']['SLIDER_ABOUT']['VALUE'])) {
                $about = $item['PROPERTIES']['SLIDER_ABOUT']['VALUE'];
            }
            ?>
            <div class="swiper-slide">
                <div class="slide-img"<?php if($img): ?> style="background-image:url('<?=$img?>')"<?php endif; ?>></div>
                <div class="slide-info">
                    <div class="slide-content">
                        <h2><?=$item['PROPERTIES']['SLIDER_NAME']['VALUE']?></h2>
                        <?php if ($about): ?>
                            <p><?=$about?></p>
                        <?php endif; ?>
                        <?if (!empty($item['PROPERTIES']['SLIDER_URL']['VALUE'])):?>
                            <a href="<?=$item['PROPERTIES']['SLIDER_URL']['VALUE']?>" class="slide-btn">
                                <?=!empty($item['PROPERTIES']['SLIDER_BTN']['VALUE']) ? $item['PROPERTIES']['SLIDER_BTN']['VALUE'] : 'Подробнее'?>
                            </a>
                        <?endif;?>
                    </div>
                </div>
            </div>
        <?endforeach;?>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.main-slider', {
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 5000,
            },
            effect: 'slide',
        });
    });
</script>
