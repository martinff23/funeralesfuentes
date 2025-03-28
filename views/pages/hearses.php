<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title;?></h2>
    <p class="page-main__description">Conoce las carrozas que ofrecemos en Funerales Fuentes</p>

    <?php if($start) { ?>
        <?php if(0 === count($hearses)){ ?>
            <h3 class="page-element__no-elements">No contamos con carrozas propias disponibles por el momento...</h3>
        <?php } else{ ?>
            <div class="hearses slider swiper">
                <div class="swiper-wrapper">
                    <?php foreach($hearses as $hearse){ ?>
                        <div class="hearse swiper-slide">
                            <div class="hearse__information">
                                <p class="hearse__name"><?php echo $hearse->hearse_name; ?></p>
                                <div class="hearse__information-details">
                                    <picture>
                                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/hearses/'.$hearse->image.'.webp'; ?>" type="image/webp">
                                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/hearses/'.$hearse->image.'.png'; ?>" type="image/png">
                                        <img class="hearse__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/hearses/'.$hearse->image.'.png'; ?>" alt="Imagen de la capilla">
                                    </picture>
                                    <p class="hearse__description"><?php echo $hearse->hearse_description; ?></p>
                                    <p class="hearse__price">Precio: $<?php echo number_format($hearse->hearse_price); ?> MXN</p>
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
        <?php if(0 === count($hearses)){ ?>
            <h3 class="page-element__no-elements">No contamos con carrozas disponibles por el momento...</h3>
        <?php } else{ ?>
            <?php foreach($hearses as $key => $hearse){ ?>
                <?php $type = 'own' === strtolower($key) ? 'Propias' : 'Externas'; ?>
                <div class="page-element">
                    <h3 class="page-element__heading"><?php echo $type; ?></h3>

                    <div class="hearses slider swiper">
                        <div class="swiper-wrapper">
                            <?php foreach($hearse as $keySS => $subhearse){ ?>
                                <div class="hearse swiper-slide">
                                    <div class="hearse__information">
                                    <p class="hearse__name"><?php echo $subhearse->hearse_name; ?></p>
                                        <div class="hearse__information-details">
                                            <picture>
                                                <source srcset="<?php echo $_ENV['HOST'].'/build/img/hearses/'.$subhearse->image.'.webp'; ?>" type="image/webp">
                                                <source srcset="<?php echo $_ENV['HOST'].'/build/img/hearses/'.$subhearse->image.'.png'; ?>" type="image/png">
                                                <img class="hearse__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/hearses/'.$subhearse->image.'.png'; ?>" alt="Imagen de la carroza">
                                            </picture>
                                            <p class="hearse__description"><?php echo $subhearse->hearse_description; ?></p>
                                            <p class="hearse__price">Precio: $<?php echo number_format($subhearse->hearse_price); ?> MXN</p>
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