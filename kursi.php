<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<style>
.courses-slider {
  width: 1100px;
  max-width: 90vw;
  margin: 48px auto 0 auto;
  font-family: 'Segoe UI', Arial, sans-serif;
}
.courses-title {
  font-size: 2.1rem;
  font-weight: 700;
  text-align: center;
  margin-bottom: 32px;
  letter-spacing: 0.01em;
}
.courses-tabs {
  display: flex;
  justify-content: center;
  gap: 32px;
  margin-bottom: 32px;
  flex-wrap: wrap;
  position: relative;
}
.courses-tab {
  background: none;
  border: none;
  font-size: 1.1rem;
  font-weight: 500;
  color: #22223b;
  padding: 8px 24px 12px 24px;
  cursor: pointer;
  transition: color 0.2s;
  outline: none;
  position: relative;
  z-index: 1;
}
.courses-tab.active,
.courses-tab:hover {
  color: #120fa0;
}
.courses-tabs-underline {
  position: absolute;
  left: 0;
  bottom: 0;
  height: 3px;
  background: #120fa0;
  border-radius: 2px;
  transition: all 0.3s cubic-bezier(.4,2,.6,1);
  z-index: 0;
  width: 0;
  transform: translateX(0);
}
.courses-slides {
  position: relative;
  min-height: 380px;
}
.courses-slide {
  display: none;
  align-items: stretch;
  background: #120fa0;
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 4px 24px rgba(18,15,160,0.08);
  padding: 0;
  min-height: 380px;
  transition: background 0.3s;
}
.courses-slide.active {
  display: flex;
  animation: fadeIn 0.5s;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(30px);}
  to { opacity: 1; transform: none;}
}
.courses-slide-media {
  flex: 0 0 44%;
  min-width: 0;
  background: #ccc;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}
.courses-slide-media img,
.courses-slide-media video {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  border: none;
  border-radius: 0;
  max-height: 380px;
  background: #ccc;
}
.courses-slide-content {
  flex: 1 1 0;
  padding: 48px 40px 32px 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background: #120fa0;
  color: #fff;
}
.courses-slide-title {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 18px;
}
.courses-slide-desc {
  font-size: 1.15rem;
  margin-bottom: 32px;
  line-height: 1.5;
  color: #f5f5f5;
}
.courses-slide-btn {
  display: inline-block;
  padding: 10px 28px;
  border: none;
  border-radius: 8px;
  color: #120fa0;
  background: #fff;
  font-size: 1.1rem;
  font-weight: 600;
  text-decoration: none;
  transition: background 0.2s, color 0.2s, box-shadow 0.2s;
  text-align: center;
  box-shadow: 0 2px 8px rgba(18,15,160,0.08);
  margin-top: 18px;
}
.courses-slide-btn:hover {
  background: #120fa0;
  color: #fff;
}
@media (max-width: 900px) {
  .courses-slider { width: 98vw; }
  .courses-slide { flex-direction: column; min-height: 0; }
  .courses-slide-media, .courses-slide-content { width: 100%; max-width: 100%; }
  .courses-slide-media { min-height: 180px; }
  .courses-slide-content { padding: 24px 12px 20px 12px; }
  .courses-slide-title { font-size: 1.3rem; }
}
</style>

<div class="courses-slider">
    <h2 class="courses-title">Наши курсы</h2>
    <div class="courses-tabs">
        <?foreach($arResult["ITEMS"] as $i => $item):?>
            <button class="courses-tab<?=($i==0?' active':'')?>" data-tab="<?=$i?>">
                <?=htmlspecialchars($item["PROPERTIES"]["NAME_KURS"]["VALUE"] ?: $item["NAME"])?>
            </button>
        <?endforeach;?>
        <div class="courses-tabs-underline"></div>
    </div>
    <div class="courses-slides">
        <?foreach($arResult["ITEMS"] as $i => $item):?>
            <div class="courses-slide<?=($i==0?' active':'')?>" data-slide="<?=$i?>">
                <div class="courses-slide-media">
                    <?if($item["PROPERTIES"]["VID_KURS"]["VALUE"]):?>
                        <video src="<?=htmlspecialchars($item["PROPERTIES"]["VID_KURS"]["VALUE"])?>" controls poster="<?=CFile::GetPath($item["PROPERTIES"]["IMG_KURS"]["VALUE"])?>"></video>
                    <?elseif($item["PROPERTIES"]["IMG_KURS"]["VALUE"]):?>
                        <img src="<?=CFile::GetPath($item["PROPERTIES"]["IMG_KURS"]["VALUE"])?>" alt="<?=htmlspecialchars($item["PROPERTIES"]["NAME_KURS"]["VALUE"] ?: $item["NAME"])?>">
                    <?endif;?>
                </div>
                <div class="courses-slide-content">
                    <div class="courses-slide-title">
                        <?=htmlspecialchars($item["PROPERTIES"]["NAME_KURS"]["VALUE"] ?: $item["NAME"])?>
                    </div>
                    <div class="courses-slide-desc">
                        <?=htmlspecialchars($item["PROPERTIES"]["TEXT_KURS"]["VALUE"])?>
                    </div>
                    <?if($item["PROPERTIES"]["LINK_KURS"]["VALUE"]):?>
                        <a href="<?=htmlspecialchars($item["PROPERTIES"]["LINK_KURS"]["VALUE"])?>" class="courses-slide-btn" target="_blank">Подробнее</a>
                    <?endif;?>
                </div>
            </div>
        <?endforeach;?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.courses-tab');
        const underline = document.querySelector('.courses-tabs-underline');
        function moveUnderline() {
            const activeTab = document.querySelector('.courses-tab.active');
            if (activeTab && underline) {
                const rect = activeTab.getBoundingClientRect();
                const parentRect = activeTab.parentElement.getBoundingClientRect();
                underline.style.width = rect.width + 'px';
                underline.style.transform = `translateX(${rect.left - parentRect.left}px)`;
            }
        }
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                // Переключение слайда
                document.querySelectorAll('.courses-slide').forEach(s => s.classList.remove('active'));
                document.querySelector('.courses-slide[data-slide="'+this.dataset.tab+'"]').classList.add('active');
                moveUnderline();
            });
        });
        window.addEventListener('resize', moveUnderline);
        moveUnderline();
    });
</script>
