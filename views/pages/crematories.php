<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title; ?></h2>
    <p class="page-main__description">Conoce los crematorios que ofrecemos en Funerales Fuentes</p>

    <?php
    function renderCrematorySlide($crematory) {
        $imageToShow = "";
        $differentImages = explode(",", $crematory->image);
        foreach ($differentImages as $differentImage) {
            if (!str_contains($differentImage, "_")) {
                $imageToShow = $differentImage;
            }
        }
        $id = 'crematory-' . $crematory->id;
        ?>
        <div id="<?php echo $id; ?>" class="crematory swiper-slide"
            data-name="<?php echo htmlspecialchars($crematory->crematory_name, ENT_QUOTES, 'UTF-8'); ?>"
            data-description="<?php echo htmlspecialchars($crematory->crematory_description, ENT_QUOTES, 'UTF-8'); ?>"
            data-price="<?php echo number_format($crematory->crematory_price); ?>"
            data-image="<?php echo $crematory->image; ?>"
            data-lat="<?php echo $crematory->latitude ? $crematory->latitude : ''; ?>"
            data-lng="<?php echo $crematory->longitude ? $crematory->longitude : ''; ?>"
            data-address="<?php echo $crematory->address ? $crematory->address : ''; ?>"
            data-imagetype="crematories">
            <div class="crematory__information">
                <p class="crematory__name"><?php echo $crematory->crematory_name; ?></p>
                <div class="crematory__information-details">
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/crematories/'.$imageToShow.'.webp'; ?>" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/crematories/'.$imageToShow.'.png'; ?>" type="image/png">
                        <img class="crematory__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/public/build/img/crematories/'.$imageToShow.'.png'; ?>" alt="Imagen del crematorio">
                    </picture>
                    <p class="crematory__description"><?php echo $crematory->crematory_description; ?></p>
                    <!-- <p class="crematory__price">Precio: $<?php echo number_format($crematory->crematory_price); ?> MXN</p> -->
                </div>
            </div>
        </div>
    <?php }
    ?>

    <?php if ($start) { ?>
        <?php if (empty($crematories)) { ?>
            <h3 class="page-element__no-elements">Estamos trabajando arduamente para tener esto a tu disposición. Esperalo muy pronto...</h3>
        <?php } else { ?>
            <div class="crematories slider swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($crematories as $crematory) renderCrematorySlide($crematory); ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <?php if (empty($crematories)) { ?>
            <h3 class="page-element__no-elements">Estamos trabajando arduamente para tener esto a tu disposición. Esperalo muy pronto...</h3>
        <?php } else {
            $order = ['own' => 'Propios', 'external' => 'Externos'];
            foreach ($order as $key => $label) {
                if (!isset($crematories[$key])) continue;
                ?>
                <div class="page-element">
                    <h3 class="page-element__heading"><?php echo $label; ?></h3>
                    <div class="crematories slider swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($crematories[$key] as $subcrematory) renderCrematorySlide($subcrematory); ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            <?php }
        } ?>
    <?php } ?>
</main>