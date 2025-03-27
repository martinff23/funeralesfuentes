<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title;?></h2>
    <p class="page-main__description">Conoce los servicios que ofrecemos en Funerales Fuentes</p>

    <?php if(0 === count($services)){ ?>
        <h3 class="page-element__no-elements">No contamos con servicios disponibles por el momento...</h3>
    <?php } else{ ?>
        <?php foreach($services as $key => $service){ ?>
        <?php $type = 'transport' === strtolower($key) ? 'Transporte' : ('funeral' === strtolower($key) ? 'Funeral' : 'Legal'); ?>
            <div class="page-element">
                <h3 class="page-element__heading"><?php echo $type; ?></h3>
                
                <div class="services slider swiper">
                    <div class="swiper-wrapper">
                        <?php foreach($service as $keySS => $subservice){ ?>
                            <div class="service swiper-slide">
                                <div class="service__information">
                                <p class="service__name"><?php echo $subservice->service_name; ?></p>
                                    <div class="service__information-details">
                                        <picture>
                                            <source srcset="<?php echo $_ENV['HOST'].'/build/img/services/'.$subservice->image.'.webp'; ?>" type="image/webp">
                                            <source srcset="<?php echo $_ENV['HOST'].'/build/img/services/'.$subservice->image.'.png'; ?>" type="image/png">
                                            <img class="service__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/services/'.$subservice->image.'.png'; ?>" alt="Imagen del servicio">
                                        </picture>
                                        <p class="service__description"><?php echo $subservice->service_description; ?></p>
                                        <p class="service__price">Precio: $<?php echo number_format($subservice->service_price); ?> MXN</p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

            </div>
        <?php } ?>
    <?php } ?>
</main>