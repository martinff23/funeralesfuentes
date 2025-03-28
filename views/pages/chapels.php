<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title;?></h2>
    <p class="page-main__description">Conoce las capillas que ofrecemos en Funerales Fuentes</p>

    <?php if($start) { ?>
        <?php if(0 === count($chapels)){ ?>
            <h3 class="page-element__no-elements">No contamos con capillas propias disponibles por el momento...</h3>
        <?php } else{ ?>
            <div class="chapels slider swiper">
                <div class="swiper-wrapper">
                    <?php foreach($chapels as $chapel){ ?>
                        <div class="chapel swiper-slide">
                            <div class="chapel__information">
                                <p class="chapel__name"><?php echo $chapel->chapel_name; ?></p>
                                <div class="chapel__information-details">
                                    <picture>
                                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/chapels/'.$chapel->image.'.webp'; ?>" type="image/webp">
                                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/chapels/'.$chapel->image.'.png'; ?>" type="image/png">
                                        <img class="chapel__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/chapels/'.$chapel->image.'.png'; ?>" alt="Imagen de la capilla">
                                    </picture>
                                    <p class="chapel__description"><?php echo $chapel->chapel_description; ?></p>
                                    <p class="chapel__price">Precio: $<?php echo number_format($chapel->chapel_price); ?> MXN</p>
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
    <?php } else { ?>
        <?php if(0 === count($chapels)){ ?>
            <h3 class="page-element__no-elements">No contamos con capillas disponibles por el momento...</h3>
        <?php } else{ ?>
            <?php foreach($chapels as $key => $chapel){ ?>
            <?php $type = 'own' === strtolower($key) ? 'Propias' : 'Externas'; ?>
                <div class="page-element">
                    <h3 class="page-element__heading"><?php echo $type; ?></h3>
                    
                    <div class="chapels slider swiper">
                        <div class="swiper-wrapper">
                            <?php foreach($chapel as $keySS => $subchapel){ ?>
                                <div class="chapel swiper-slide">
                                    <div class="chapel__information">
                                    <p class="chapel__name"><?php echo $subchapel->chapel_name; ?></p>
                                        <div class="chapel__information-details">
                                            <picture>
                                                <source srcset="<?php echo $_ENV['HOST'].'/build/img/chapels/'.$subchapel->image.'.webp'; ?>" type="image/webp">
                                                <source srcset="<?php echo $_ENV['HOST'].'/build/img/chapels/'.$subchapel->image.'.png'; ?>" type="image/png">
                                                <img class="chapel__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/chapels/'.$subchapel->image.'.png'; ?>" alt="Imagen de la capilla">
                                            </picture>
                                            <p class="chapel__description"><?php echo $subchapel->chapel_description; ?></p>
                                            <p class="chapel__price">Precio: $<?php echo number_format($subchapel->chapel_price); ?> MXN</p>
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
    <?php }?>
</main>