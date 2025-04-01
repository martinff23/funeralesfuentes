<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title;?></h2>
    <p class="page-main__description">Conoce los cementerios que ofrecemos en Funerales Fuentes</p>

    <?php if($start) { ?>
        <?php if(0 === count($cemeteries)){ ?>
            <h3 class="page-element__no-elements">No contamos con cementerios propios disponibles por el momento...</h3>
        <?php } else{ ?>
            <div class="cemeteries slider swiper">
                <div class="swiper-wrapper">
                    <?php foreach($cemeteries as $cemetery){ ?>
                        <?php
                            $imageToShow = "";
                            $differentImages = explode(",", $cemetery->image);
                            foreach($differentImages as $differentImage){
                                if(!str_contains($differentImage, "_")){
                                    $imageToShow = $differentImage;
                                }
                            }    
                        ?>
                        <div class="cemetery swiper-slide">
                            <div class="cemetery__information">
                                <p class="cemetery__name"><?php echo $cemetery->cemetery_name; ?></p>
                                <div class="cemetery__information-details">
                                    <picture>
                                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/cemeteries/'.$imageToShow.'.webp'; ?>" type="image/webp">
                                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/cemeteries/'.$imageToShow.'.png'; ?>" type="image/png">
                                        <img class="cemetery__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/cemeteries/'.$imageToShow.'.png'; ?>" alt="Imagen de la capilla">
                                    </picture>
                                    <p class="cemetery__description"><?php echo $cemetery->cemetery_description; ?></p>
                                    <p class="cemetery__price">Precio: $<?php echo number_format($cemetery->cemetery_price); ?> MXN</p>
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
        <?php if(0 === count($cemeteries)){ ?>
            <h3 class="page-element__no-elements">No contamos con cementerios disponibles por el momento...</h3>
        <?php } else{ ?>
            <?php foreach($cemeteries as $key => $cemetery){ ?>
                <?php $type = 'own' === strtolower($key) ? 'Propios' : 'Externos'; ?>
                <div class="page-element">
                    <h3 class="page-element__heading"><?php echo $type; ?></h3>
                    
                    <div class="cemeteries slider swiper">
                        <div class="swiper-wrapper">
                            <?php foreach($cemetery as $keySS => $subcemetery){ ?>
                                <?php
                                    $imageToShow = "";
                                    $differentImages = explode(",", $subcemetery->image);
                                    foreach($differentImages as $differentImage){
                                        if(!str_contains($differentImage, "_")){
                                            $imageToShow = $differentImage;
                                        }
                                    }    
                                ?>
                                <div class="cemetery swiper-slide">
                                    <div class="cemetery__information">
                                    <p class="cemetery__name"><?php echo $subcemetery->cemetery_name; ?></p>
                                        <div class="cemetery__information-details">
                                            <picture>
                                                <source srcset="<?php echo $_ENV['HOST'].'/build/img/cemeteries/'.$imageToShow.'.webp'; ?>" type="image/webp">
                                                <source srcset="<?php echo $_ENV['HOST'].'/build/img/cemeteries/'.$imageToShow.'.png'; ?>" type="image/png">
                                                <img class="cemetery__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/cemeteries/'.$imageToShow.'.png'; ?>" alt="Imagen del cementerio">
                                            </picture>
                                            <p class="cemetery__description"><?php echo $subcemetery->cemetery_description; ?></p>
                                            <p class="cemetery__price">Precio: $<?php echo number_format($subcemetery->cemetery_price); ?> MXN</p>
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