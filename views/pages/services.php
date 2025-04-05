<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title;?></h2>
    <p class="page-main__description">Conoce los servicios que ofrecemos en Funerales Fuentes</p>

    <?php if(0 === count($services)){ ?>
        <h3 class="page-element__no-elements">Estamos trabajando arduamente para tener esto a tu disposición. Esperalo muy pronto...</h3>
    <?php } else {
        $order = ['funeral' => 'Funeral', 'transport' => 'Transporte', 'legal' => 'Legal'];
        foreach ($order as $key => $type) {
            if (!isset($services[$key])) continue;
            ?>
            <div class="page-element">
                <h3 class="page-element__heading"><?php echo $type; ?></h3>
                <div class="services slider swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($services[$key] as $subservice):
                            $imageToShow = "";
                            $differentImages = explode(",", $subservice->image);
                            foreach ($differentImages as $differentImage) {
                                if (!str_contains($differentImage, "_")) {
                                    $imageToShow = $differentImage;
                                }
                            }
                            $id = 'service-' . $subservice->id;
                        ?>
                        <div id="<?php echo $id; ?>" class="service swiper-slide"
                            data-name="<?php echo htmlspecialchars($subservice->service_name, ENT_QUOTES, 'UTF-8'); ?>"
                            data-description="<?php echo htmlspecialchars($subservice->service_description, ENT_QUOTES, 'UTF-8'); ?>"
                            data-price="<?php echo isset($subservice->service_price) ? number_format($subservice->service_price) : ''; ?>"
                            data-image="<?php echo $subservice->image; ?>"
                            data-imagetype="services">
                            <div class="service__information">
                                <p class="service__name"><?php echo $subservice->service_name; ?></p>
                                <div class="service__information-details">
                                    <picture>
                                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/services/'.$imageToShow.'.webp'; ?>" type="image/webp">
                                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/services/'.$imageToShow.'.png'; ?>" type="image/png">
                                        <img class="service__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/services/'.$imageToShow.'.png'; ?>" alt="Imagen del servicio">
                                    </picture>
                                    <p class="service__description"><?php echo $subservice->service_description; ?></p>
                                    <!-- <p class="service__price">Precio: $<?php echo number_format($subservice->service_price); ?> MXN</p> -->
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