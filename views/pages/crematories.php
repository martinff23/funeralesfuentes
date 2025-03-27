<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title;?></h2>
    <p class="page-main__description">Conoce los crematorios que ofrecemos en Funerales Fuentes</p>

    <?php if(0 === count($crematories)){ ?>
        <h3 class="page-element__no-elements">No contamos con crematorios disponibles por el momento...</h3>
    <?php } else{ ?>
        <?php foreach($crematories as $key => $crematory){ ?>
            <?php $type = 'own' === strtolower($key) ? 'Propios' : 'Externos'; ?>
            <div class="page-element">
                <h3 class="page-element__heading"><?php echo $type; ?></h3>
                
                <div class="crematories slider swiper">
                    <div class="swiper-wrapper">
                        <?php foreach($crematory as $keySS => $subcrematory){ ?>
                            <div class="crematory swiper-slide">
                                <div class="crematory__information">
                                <p class="crematory__name"><?php echo $subcrematory->crematory_name; ?></p>
                                    <div class="crematory__information-details">
                                        <picture>
                                            <source srcset="<?php echo $_ENV['HOST'].'/build/img/crematories/'.$subcrematory->image.'.webp'; ?>" type="image/webp">
                                            <source srcset="<?php echo $_ENV['HOST'].'/build/img/crematories/'.$subcrematory->image.'.png'; ?>" type="image/png">
                                            <img class="crematory__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/crematories/'.$subcrematory->image.'.png'; ?>" alt="Imagen del crematorio">
                                        </picture>
                                        <p class="crematory__description"><?php echo $subcrematory->crematory_description; ?></p>
                                        <p class="crematory__price">Precio: $<?php echo number_format($subcrematory->crematory_price); ?> MXN</p>
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