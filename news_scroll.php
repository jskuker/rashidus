<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<style>
/* Контейнер блока новостей */
.news-block {
  width: 1100px;
  max-width: 80vw;
  margin: 32px auto 0 auto; /* сверху чуть меньше, снизу 0 */
  padding: 0;
}

/* Заголовок блока новостей */
.news-block-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #22223b;
  margin-bottom: 18px;
  margin-left: 0;
  text-align: left;
  font-family: 'Segoe UI', 'Arial', sans-serif;
  letter-spacing: 0.01em;
  position: relative;
  padding-left: 0;
}
.news-block-title::after {
  content: '';
  display: block;
  width: 38px;
  height: 3px;
  background: #120fa0;
  border-radius: 2px;
  margin-top: 7px;
}

/* Горизонтальный скролл новостей */
.news-scroll {
  display: flex;
  gap: 20px;
  overflow-x: auto;
  overflow-y: visible; /* <-- добавь это! */
  scroll-behavior: smooth;
  padding: 0 0 20px 0;
  scrollbar-width: thin;
  scrollbar-color: #120fa0 #f0f0f0;
  width: 100%;
  position: relative;   /* <-- добавь это! */
}

.news-scroll::-webkit-scrollbar {
  height: 8px;
}
.news-scroll::-webkit-scrollbar-thumb {
  background: #120fa0;
  border-radius: 4px;
}
.news-scroll::-webkit-scrollbar-track {
  background: #f0f0f0;
  border-radius: 4px;
}

/* Карточка новости */
.news-card {
  min-width: 260px;
  max-width: 260px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  overflow: visible;
  transition: transform 0.3s, box-shadow 0.3s;
  flex-shrink: 0;
  position: relative;
  z-index: 1;
  transition:
          transform 0.3s cubic-bezier(.4,2,.6,1),
          box-shadow 0.3s,
          z-index 0s;
}
.news-card:hover {
  transform: scale(1.13) translateY(-12px);
  box-shadow: 0 12px 36px rgba(18,15,160,0.22);
  z-index: 10;
}

/* Картинка новости */
.news-card-img {
  height: 120px;
  overflow: hidden;
  background: #f0f0f0;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: height 0.3s cubic-bezier(.4,2,.6,1);
}
.news-card:hover .news-card-img {
  height: 200px;
}
.news-card-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s cubic-bezier(.4,2,.6,1);
}
.news-card:hover .news-card-img img {
  transform: scale(1.07);
}
.news-card-img-placeholder {
  width: 100%;
  height: 100%;
  background: linear-gradient(45deg, #f0f0f0, #e0e0e0);
}

/* Дата новости */
.news-card-date {
  font-size: 12px;
  color: #888;
  margin: 12px 0 6px 0;
  text-align: left;
  padding: 0 16px;
}

/* Заголовок новости */
.news-card-title {
  font-size: 15px;
  font-weight: 700;
  margin: 0 0 8px 0;
  line-height: 1.3;
  text-align: left;
  padding: 0 16px;
  color: #120fa0;
  transition: font-size 0.3s;
}
.news-card:hover .news-card-title {
  font-size: 17px;
}

/* Ссылка на карточку — убираем подчеркивание */
.news-card a {
  text-decoration: none !important;
  color: inherit;
  display: block;
}

/* Текст новости */
.news-card-text {
  font-size: 13px;
  color: #444;
  line-height: 1.5;
  padding: 0 16px 16px 16px;
  text-align: left;
  min-height: 34px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  transition: all 0.3s;
}
.news-card:hover .news-card-text {
  display: block;
  -webkit-line-clamp: unset;
  max-height: none;
  white-space: normal;
  font-size: 15px;
  color: #22223b;
  background: none;
}

/* Контейнер для заголовка и текста — светлый фон для читаемости */
.news-card-content-bg {
  background: rgba(255,255,255,0.97);
  border-bottom-left-radius: 12px;
  border-bottom-right-radius: 12px;
  padding-bottom: 8px;
  transition: background 0.3s;
  position: relative;
  z-index: 2;
}

/* Адаптивность */
@media (max-width: 1200px) {
  .news-block {
    width: 95vw;
    max-width: 95vw;
  }
}
@media (max-width: 900px) {
  .news-card {
    min-width: 180px;
    max-width: 180px;
  }
  .news-card-img {
    height: 80px;
  }
  .news-block-title {
    font-size: 1.1rem;
  }
}
</style>

<div class="news-block">
    <div class="news-block-title">Новости нашей продукции</div>
    <div class="news-scroll" id="news-scroll">
        <?foreach($arResult["ITEMS"] as $item):?>
            <div class="news-card">
                <a href="<?=$item["DETAIL_PAGE_URL"]?>">
                    <div class="news-card-img">
                        <?if($item["PROPERTIES"]["NEWS_IMG"]["VALUE"]):?>
                            <img src="<?=CFile::GetPath($item["PROPERTIES"]["NEWS_IMG"]["VALUE"])?>" alt="<?=htmlspecialchars($item["NAME"])?>">
                        <?else:?>
                            <div class="news-card-img-placeholder"></div>
                        <?endif;?>
                    </div>
                    <div class="news-card-date">
                        <?=htmlspecialchars($item["PROPERTIES"]["NEWS_DATA"]["VALUE"])?>
                    </div>
                    <div class="news-card-content-bg">
                        <div class="news-card-title">
                            <?=htmlspecialchars($item["NAME"])?>
                        </div>
                        <div class="news-card-text">
                            <?=htmlspecialchars($item["PROPERTIES"]["NEWS_TEXT"]["VALUE"])?>
                        </div>
                    </div>
                </a>
            </div>
        <?endforeach;?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scrollContainer = document.getElementById('news-scroll');
        const leftBtn = document.querySelector('.news-arrow.left');
        const rightBtn = document.querySelector('.news-arrow.right');
        const scrollStep = 320; // ширина карточки + gap

        if (leftBtn) {
            leftBtn.addEventListener('click', function() {
                scrollContainer.scrollBy({ left: -scrollStep, behavior: 'smooth' });
            });
        }
        if (rightBtn) {
            rightBtn.addEventListener('click', function() {
                scrollContainer.scrollBy({ left: scrollStep, behavior: 'smooth' });
            });
        }
    });
</script>
