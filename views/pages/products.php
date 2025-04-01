<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title;?></h2>
    <p class="page-main__description">Conoce los productos que vendemos en Funerales Fuentes</p>

    <?php if(0 === count($products)){ ?>
        <h3 class="page-element__no-elements">No contamos con productos disponibles por el momento...</h3>
    <?php } else{ ?>
        <?php foreach($products as $key => $product){ ?>
        <?php $type = 'coffins' === strtolower($key) ? 'Ataúdes' : 'Urnas'; ?>
            <div class="page-element">
                <h3 class="page-element__heading"><?php echo $type; ?></h3>
                <?php foreach($product as $keySP => $subproduct){ ?>
                <?php $subtype = 'ecological' === strtolower($keySP) ? 'Ecológico' : ('metallic' === strtolower($keySP) ? 'Metálico' : 'Madera'); ?>
                    <p class="page-element__type"><?php echo $subtype; ?></p>

                    <div class="products slider swiper">
                        <div class="swiper-wrapper">
                            <?php foreach($subproduct as $keySSP => $subsubproduct){ ?>
                                <?php
                                    $imageToShow = "";
                                    $differentImages = explode(",", $subsubproduct->image);
                                    foreach($differentImages as $differentImage){
                                        if(!str_contains($differentImage, "_")){
                                            $imageToShow = $differentImage;
                                        }
                                    }    
                                ?>
                                <div class="product swiper-slide">
                                    <div class="product__information">
                                    <p class="product__name"><?php echo $subsubproduct->product_name; ?></p>
                                        <div class="product__information-details">
                                            <picture>
                                                <source srcset="<?php echo $_ENV['HOST'].'/build/img/products/'.$imageToShow.'.webp'; ?>" type="image/webp">
                                                <source srcset="<?php echo $_ENV['HOST'].'/build/img/products/'.$imageToShow.'.png'; ?>" type="image/png">
                                                <img class="product__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/products/'.$imageToShow.'.png'; ?>" alt="Imagen del producto">
                                            </picture>
                                            <p class="product__description"><?php echo $subsubproduct->product_description; ?></p>
                                            <p class="product__price">Precio: $<?php echo number_format($subsubproduct->product_price); ?> MXN</p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                <?php } ?>
            </div> 
        <?php } ?>
    <?php } ?>
</main>