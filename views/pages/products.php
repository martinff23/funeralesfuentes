<?php /** @var array $products */ ?>
<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title; ?></h2>
    <p class="page-main__description">Conoce los productos que vendemos en Funerales Fuentes</p>

    <?php if (empty($products)) { ?>
        <h3 class="page-element__no-elements">Estamos trabajando arduamente para tener esto a tu disposición. Esperalo muy pronto...</h3>
    <?php } else {
        $order = [
            'coffins' => ['wooden', 'metallic', 'ecological'],
            'urns' => ['wooden', 'ecological', 'marble', 'metallic']
        ];

        foreach ($order as $group => $subtypes) {
            if (!isset($products[$group])) continue;

            $type = $group === 'coffins' ? 'Ataúdes' : 'Urnas';
            echo '<div class="page-element">';
            echo '<h3 class="page-element__heading">' . $type . '</h3>';

            foreach ($subtypes as $subtype) {
                if (!isset($products[$group][$subtype])) continue;

                $subtypeName = $subtype === 'ecological' ? 'Ecológico' : ($subtype === 'metallic' ? 'Metal' : ($subtype === 'wooden' ? 'Madera' : 'Mármol'));
                echo '<p class="page-element__type">' . $subtypeName . '</p>'; ?>

                <div class="products slider swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($products[$group][$subtype] as $subsubproduct):
                            $imageToShow = "";
                            $differentImages = explode(",", $subsubproduct->image);
                            foreach ($differentImages as $differentImage) {
                                if (!str_contains($differentImage, "_")) {
                                    $imageToShow = $differentImage;
                                }
                            }
                            $id = 'product-' . $subsubproduct->id;
                        ?>

                            <div id="<?php echo $id; ?>" class="product swiper-slide"
                                data-name="<?php echo htmlspecialchars($subsubproduct->product_name, ENT_QUOTES, 'UTF-8'); ?>"
                                data-description="<?php echo htmlspecialchars($subsubproduct->product_description, ENT_QUOTES, 'UTF-8'); ?>"
                                data-price="<?php echo number_format($subsubproduct->product_price); ?>"
                                data-image="<?php echo $subsubproduct->image; ?>"
                                data-imagetype="products">
                                <div class="product__information">
                                    <p class="product__name"><?php echo $subsubproduct->product_name; ?></p>
                                    <div class="product__information-details">
                                        <picture>
                                            <source srcset="<?php echo $_ENV['HOST'].'/build/img/products/'.$imageToShow.'.webp'; ?>" type="image/webp">
                                            <source srcset="<?php echo $_ENV['HOST'].'/build/img/products/'.$imageToShow.'.png'; ?>" type="image/png">
                                            <img class="product__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/products/'.$imageToShow.'.png'; ?>" alt="Imagen del producto">
                                        </picture>
                                        <p class="product__description"><?php echo $subsubproduct->product_description; ?></p>
                                        <!-- <p class="product__price">Precio: $<?php echo number_format($subsubproduct->product_price); ?> MXN</p> -->
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            <?php }
            echo '</div>';
        }
    } ?>
</main>