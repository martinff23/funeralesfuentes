<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title; ?></h2>
    <p class="page-main__description">Conoce las capillas que ofrecemos en Funerales Fuentes</p>

    <?php
    function renderChapelSlide($chapel) {
        $imageToShow = "";
        $differentImages = explode(",", $chapel->image);
        foreach ($differentImages as $differentImage) {
            if (!str_contains($differentImage, "_")) {
                $imageToShow = $differentImage;
            }
        }
        $id = 'chapel-' . $chapel->id;
        ?>
        <div id="<?php echo $id; ?>" class="chapel swiper-slide"
            data-name="<?php echo htmlspecialchars($chapel->chapel_name, ENT_QUOTES, 'UTF-8'); ?>"
            data-description="<?php echo htmlspecialchars($chapel->chapel_description, ENT_QUOTES, 'UTF-8'); ?>"
            data-price="<?php echo number_format($chapel->chapel_price); ?>"
            data-image="<?php echo $chapel->image; ?>"
            data-lat="<?php echo $chapel->latitude ? $chapel->latitude : ''; ?>"
            data-lng="<?php echo $chapel->longitude ? $chapel->longitude : ''; ?>"
            data-address="<?php echo $chapel->address ? $chapel->address : ''; ?>"
            data-imagetype="chapels">
            <div class="chapel__information">
                <p class="chapel__name"><?php echo $chapel->chapel_name; ?></p>
                <div class="chapel__information-details">
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/chapels/'.$imageToShow.'.webp'; ?>" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/chapels/'.$imageToShow.'.png'; ?>" type="image/png">
                        <img class="chapel__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/chapels/'.$imageToShow.'.png'; ?>" alt="Imagen de la capilla">
                    </picture>
                    <p class="chapel__description"><?php echo $chapel->chapel_description; ?></p>
                    <!-- <p class="chapel__price">Precio: $<?php echo number_format($chapel->chapel_price); ?> MXN</p> -->
                </div>
            </div>
        </div>
    <?php }
    ?>

    <?php if ($start) { ?>
        <?php if (empty($chapels)) { ?>
            <h3 class="page-element__no-elements">Estamos trabajando arduamente para tener esto a tu disposición. Esperalo muy pronto...</h3>
        <?php } else { ?>
            <div class="chapels slider swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($chapels as $chapel) renderChapelSlide($chapel); ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <?php if (empty($chapels)) { ?>
            <h3 class="page-element__no-elements">Estamos trabajando arduamente para tener esto a tu disposición. Esperalo muy pronto...</h3>
        <?php } else {
            $order = ['own' => 'Propias', 'external' => 'Externas'];
            foreach ($order as $key => $label) {
                if (!isset($chapels[$key])) continue;
                ?>
                <div class="page-element">
                    <h3 class="page-element__heading"><?php echo $label; ?></h3>
                    <div class="chapels slider swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($chapels[$key] as $subchapel) renderChapelSlide($subchapel); ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            <?php }
        } ?>
    <?php } ?>
</main>