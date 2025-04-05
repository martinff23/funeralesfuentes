<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title; ?></h2>
    <p class="page-main__description">Conoce los cementerios que ofrecemos en Funerales Fuentes</p>

    <?php
    function renderCemeterySlide($cemetery) {
        $imageToShow = "";
        $differentImages = explode(",", $cemetery->image);
        foreach ($differentImages as $differentImage) {
            if (!str_contains($differentImage, "_")) {
                $imageToShow = $differentImage;
            }
        }
        $id = 'cemetery-' . $cemetery->id;
        ?>
        <div id="<?php echo $id; ?>" class="cemetery swiper-slide"
            data-name="<?php echo htmlspecialchars($cemetery->cemetery_name, ENT_QUOTES, 'UTF-8'); ?>"
            data-description="<?php echo htmlspecialchars($cemetery->cemetery_description, ENT_QUOTES, 'UTF-8'); ?>"
            data-price="<?php echo number_format($cemetery->cemetery_price); ?>"
            data-image="<?php echo $cemetery->image; ?>"
            data-lat="<?php echo $cemetery->latitude ? $cemetery->latitude : ''; ?>"
            data-lng="<?php echo $cemetery->longitude ? $cemetery->longitude : ''; ?>"
            data-address="<?php echo $cemetery->address ? $cemetery->address : ''; ?>"
            data-imagetype="cemeteries">
            <div class="cemetery__information">
                <p class="cemetery__name"><?php echo $cemetery->cemetery_name; ?></p>
                <div class="cemetery__information-details">
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/cemeteries/'.$imageToShow.'.webp'; ?>" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/cemeteries/'.$imageToShow.'.png'; ?>" type="image/png">
                        <img class="cemetery__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/cemeteries/'.$imageToShow.'.png'; ?>" alt="Imagen del cementerio">
                    </picture>
                    <p class="cemetery__description"><?php echo $cemetery->cemetery_description; ?></p>
                    <!-- <p class="cemetery__price">Precio: $<?php echo number_format($cemetery->cemetery_price); ?> MXN</p> -->
                </div>
            </div>
        </div>
    <?php }
    ?>

    <?php if ($start) { ?>
        <?php if (empty($cemeteries)) { ?>
            <h3 class="page-element__no-elements">Estamos trabajando arduamente para tener esto a tu disposición. Esperalo muy pronto...</h3>
        <?php } else { ?>
            <div class="cemeteries slider swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($cemeteries as $cemetery) renderCemeterySlide($cemetery); ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <?php if (empty($cemeteries)) { ?>
            <h3 class="page-element__no-elements">Estamos trabajando arduamente para tener esto a tu disposición. Esperalo muy pronto...</h3>
        <?php } else {
            $order = ['own' => 'Propios', 'external' => 'Externos'];
            foreach ($order as $key => $label) {
                if (!isset($cemeteries[$key])) continue;
                ?>
                <div class="page-element">
                    <h3 class="page-element__heading"><?php echo $label; ?></h3>
                    <div class="cemeteries slider swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($cemeteries[$key] as $subcemetery) renderCemeterySlide($subcemetery); ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            <?php }
        } ?>
    <?php } ?>
</main>