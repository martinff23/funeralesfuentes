<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title;?></h2>
    <p class="page-main__description">Conoce las sucursales y puntos de venta de Funerales Fuentes</p>

        <?php if(0 === count($branches)){ ?>
            <h3 class="page-element__no-elements">No contamos con capillas disponibles por el momento...</h3>
        <?php } else{ ?>
            <?php foreach($branches as $key => $branch){ ?>
            <?php $type = 'fix' === strtolower($key) ? 'Sucursales' : 'Puntos de venta'; ?>
                <div class="page-element">
                    <h3 class="page-element__heading"><?php echo $type; ?></h3>
                    
                    <div class="branches slider swiper">
                        <div class="swiper-wrapper">
                            <?php foreach($branch as $keySS => $subbranch){ ?>
                                <?php
                                    $imageToShow = "";
                                    $differentImages = explode(",", $subbranch->image);
                                    foreach($differentImages as $differentImage){
                                        if(!str_contains($differentImage, "_")){
                                            $imageToShow = $differentImage;
                                        }
                                    }    
                                ?>
                                <div class="branch swiper-slide">
                                    <div class="branch__information">
                                    <p class="branch__name"><?php echo $subbranch->branch_name; ?></p>
                                        <div class="branch__information-details">
                                            <picture>
                                                <source srcset="<?php echo $_ENV['HOST'].'/build/img/branches/'.$imageToShow.'.webp'; ?>" type="image/webp">
                                                <source srcset="<?php echo $_ENV['HOST'].'/build/img/branches/'.$imageToShow.'.png'; ?>" type="image/png">
                                                <img class="branch__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/branches/'.$imageToShow.'.png'; ?>" alt="Imagen de la capilla">
                                            </picture>
                                            <p class="branch__description"><?php echo $subbranch->branch_description; ?></p>
                                            <p class="branch__price">Precio: $<?php echo number_format($subbranch->branch_price); ?> MXN</p>
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