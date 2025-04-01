<fieldset class="form__fieldset">
    <legend class="form__legend">Información del producto</legend>
    <div class="form__field">
        <label for="product_name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="product_name" name="product_name" placeholder="Nombre del producto" value="<?php echo $product->product_name??'';?>">
    </div>
    <div class="form__field">
        <label for="product_description" class="form__label">Descripción</label>
        <input type="text" class="form__input" id="product_description" name="product_description" placeholder="Descripción del producto" value="<?php echo $product->product_description??'';?>">
    </div>
    <div class="form__field">
        <label for="product_cost" class="form__label">Costo</label>
        <input type="text" class="form__input" id="product_cost" name="product_cost" placeholder="Costo del producto" value="<?php echo $product->product_cost??'';?>">
    </div>
    <div class="form__field">
        <label for="SKU" class="form__label">SKU</label>
        <input type="text" class="form__input" id="SKU" name="SKU" placeholder="SKU" value="<?php echo $product->SKU??'';?>">
    </div>
    <div class="form__field">
        <label for="product_inventory" class="form__label">Inventario</label>
        <input type="text" class="form__input" id="product_inventory" name="product_inventory" placeholder="Cantidad de productos" value="<?php echo $product->product_inventory??'';?>">
    </div>
    <div class="form__field">
        <label for="product_image" class="form__label">Imagen</label>
        <input type="file" class="form__input form__input--file" id="product_image" name="product_image[]" multiple accept="image/*">
        <!-- <input type="file" class="form__input form__input--file" id="product_image" name="product_image"> -->
    </div>

    <?php if(isset($product->currentImage)) {?>
        <p class="form__text">Imagen actual:</p>
        <div class="form__image">
            <?php if($flag){ ?>
                <?php foreach($differentImages as $differentImage){ ?>
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/products/'.$differentImage.'.webp'; ?>" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/products/'.$differentImage.'.png'; ?>" type="image/png">
                        <img src="<?php echo $_ENV['HOST'].'/build/img/products/'.$differentImage.'.png'; ?>" alt="Imagen del producto">
                    </picture>
                <?php } ?>
            <?php } else{ ?>
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'].'/build/img/products/'.$product->currentImage.'.webp'; ?>" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'].'/build/img/products/'.$product->currentImage.'.png'; ?>" type="image/png">
                    <img src="<?php echo $_ENV['HOST'].'/build/img/products/'.$product->currentImage.'.png'; ?>" alt="Imagen del producto">
                </picture>
            <?php } ?>
        </div>
    <?php }?>

</fieldset>

<fieldset class="form__fieldset">
    <legend for="product_tags" class="form__legend">Información adicional del producto</legend>
    <div class="form__field">
        <label class="form__label" for="category">Categoría</label>
        <select class="form__select" id="category" name="category_id">
            <option value="">- Seleccionar -</option>
            <?php foreach($categories as $category){ ?>
                <option value="<?php echo $category->id;?>" <?php echo ($category->id===$product->category_id) ? 'selected' : ''; ?>><?php echo $category->visible_name;?></option>
            <?php }?>
        </select>
    </div>
    <div class="form__field">
        <label class="form__label" for="caracteristics">Características (separadas por coma)</label>
        <input type="text" class="form__input" id="product_tags" placeholder="Ejemplo: Ataúd, Caoba, Biodegradable">
        <div id="tags" class="form__list"></div>
        <input type="hidden" name="tags" value="<?php echo $product->tags??'';?>">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend for="product_video" class="form__legend">Video del producto</legend>
    <div class="form__field">
        <div class="form__icon-container">
            <div class="form__icon">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input type="text" class="form__input--socials" name="product_networks[youtube]" placeholder="YouTube" value="<?php echo $networks->youtube??'';?>">
        </div>
    </div>
</fieldset>