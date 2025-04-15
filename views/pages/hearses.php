<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title; ?></h2>
    <p class="page-main__description">Conoce las carrozas que ofrecemos en Funerales Fuentes</p>

    <?php
    function renderHearseSlide($hearse) {
        $imageToShow = "";
        $differentImages = explode(",", $hearse->image);
        foreach ($differentImages as $differentImage) {
            if (!str_contains($differentImage, "_")) {
                $imageToShow = $differentImage;
            }
        }
        $id = 'hearse-' . $hearse->id;
        ?>
        <div id="<?php echo $id; ?>" class="hearse swiper-slide"
            data-name="<?php echo htmlspecialchars($hearse->hearse_name, ENT_QUOTES, 'UTF-8'); ?>"
            data-description="<?php echo htmlspecialchars($hearse->hearse_description, ENT_QUOTES, 'UTF-8'); ?>"
            data-price="<?php echo number_format($hearse->hearse_price); ?>"
            data-image="<?php echo $imageToShow; ?>"
            data-imagetype="hearses">
            <div class="hearse__information">
                <p class="hearse__name"><?php echo $hearse->hearse_name; ?></p>
                <div class="hearse__information-details">
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/hearses/'.$imageToShow.'.webp'; ?>" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/hearses/'.$imageToShow.'.png'; ?>" type="image/png">
                        <img class="hearse__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/public/build/img/hearses/'.$imageToShow.'.png'; ?>" alt="Imagen de la carroza">
                    </picture>
                    <p class="hearse__description"><?php echo $hearse->hearse_description; ?></p>
                    <!-- <p class="hearse__price">Precio: $<?php echo number_format($hearse->hearse_price); ?> MXN</p> -->
                </div>
            </div>
        </div>
    <?php }
    ?>

    <?php if ($start) { ?>
        <?php if (empty($hearses)) { ?>
            <h3 class="page-element__no-elements">Estamos trabajando arduamente para tener esto a tu disposición. Esperalo muy pronto...</h3>
            <picture>
                <img class="error__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/public/build/img/wip/'.$selectedImage; ?>" alt="Imagen del trabajo en curso">
            </picture>
        <?php } else { ?>
            <div class="hearses slider swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($hearses as $hearse) renderHearseSlide($hearse); ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <?php if (empty($hearses)) { ?>
            <h3 class="page-element__no-elements">Estamos trabajando arduamente para tener esto a tu disposición. Esperalo muy pronto...</h3>
            <picture>
                <img class="error__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/public/build/img/wip/'.$selectedImage; ?>" alt="Imagen del trabajo en curso">
            </picture>
        <?php } else {
            $order = ['own' => 'Propias', 'external' => 'Externas'];
            foreach ($order as $key => $label) {
                if (!isset($hearses[$key])) continue;
                ?>
                <div class="page-element">
                    <h3 class="page-element__heading"><?php echo $label; ?></h3>
                    <div class="hearses slider swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($hearses[$key] as $subhearse) renderHearseSlide($subhearse); ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            <?php }
        } ?>
    <?php } ?>
</main>