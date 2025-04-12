<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title; ?></h2>
    <p class="page-main__description">Conoce las sucursales y puntos de venta de Funerales Fuentes</p>

    <?php if (empty($branches)) { ?>
        <h3 class="page-element__no-elements">Estamos trabajando arduamente para tener esto a tu disposición. Esperalo muy pronto...</h3>
    <?php } else {
        $order = ['fix' => 'Sucursales', 'pos' => 'Puntos de venta'];
        
        foreach ($order as $key => $label) {
            if (!isset($branches[$key])) continue;
            ?>
            <div class="page-element">
                <h3 class="page-element__heading"><?php echo $label; ?></h3>
                <div class="branches slider swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($branches[$key] as $subbranch):
                            $imageToShow = "";
                            $differentImages = explode(",", $subbranch->image);
                            foreach ($differentImages as $differentImage) {
                                if (!str_contains($differentImage, "_")) {
                                    $imageToShow = $differentImage;
                                }
                            }
                            $id = 'branch-' . $subbranch->id;
                        ?>
                        <div id="<?php echo $id; ?>" class="branch swiper-slide"
                            data-name="<?php echo htmlspecialchars($subbranch->branch_name, ENT_QUOTES, 'UTF-8'); ?>"
                            data-description="<?php echo htmlspecialchars($subbranch->branch_description, ENT_QUOTES, 'UTF-8'); ?>"
                            data-price="<?php echo number_format($subbranch->branch_price); ?>"
                            data-image="<?php echo $subbranch->image; ?>"
                            data-lat="<?php echo $subbranch->latitude ? $subbranch->latitude : ''; ?>"
                            data-lng="<?php echo $subbranch->longitude ? $subbranch->longitude : ''; ?>"
                            data-address="<?php echo $subbranch->address ? $subbranch->address : ''; ?>"
                            data-imagetype="branches">
                            <div class="branch__information">
                                <p class="branch__name"><?php echo $subbranch->branch_name; ?></p>
                                <div class="branch__information-details">
                                    <picture>
                                        <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/branches/'.$imageToShow.'.webp'; ?>" type="image/webp">
                                        <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/branches/'.$imageToShow.'.png'; ?>" type="image/png">
                                        <img class="branch__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/public/build/img/branches/'.$imageToShow.'.png'; ?>" alt="Imagen de la capilla">
                                    </picture>
                                    <p class="branch__description"><?php echo $subbranch->branch_description; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        <?php }
    } ?>
</main>