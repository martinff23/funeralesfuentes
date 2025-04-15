<fieldset class="form__fieldset">
    <legend class="form__legend">Información del cementerio</legend>
    <div class="form__field">
        <label for="cemetery_name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="cemetery_name" name="cemetery_name" placeholder="Nombre del cementerio" value="<?php echo $cemetery->cemetery_name??'';?>">
    </div>
    <div class="form__field">
        <label for="cemetery_description" class="form__label">Descripción</label>
        <input type="text" class="form__input" id="cemetery_description" name="cemetery_description" placeholder="Descripción del cementerio" value="<?php echo $cemetery->cemetery_description??'';?>">
    </div>
    <div class="form__field">
        <label for="cemetery_cost" class="form__label">Costo</label>
        <input type="text" class="form__input" id="cemetery_cost" name="cemetery_cost" placeholder="Costo del cementerio" value="<?php echo $cemetery->cemetery_cost??'';?>">
    </div>
    <div class="form__field">
        <label for="open_date" class="form__label">Fecha apertura</label>
        <input type="date" class="form__input" id="open_date" name="open_date" placeholder="Longitud" value="<?php echo $cemetery->open_date??'';?>">
    </div>
    <div class="form__field">
        <label for="status" class="form__label">Estado</label>
        <select class="form__input" id="status" name="status">
            <option value="NONE" <?php echo empty($cemetery->status) ? 'selected' : '';?>>- SELECCIONA UN ESTADO -</option>
            <option value="ACTIVE" <?php echo 'ACTIVE' === strtoupper($cemetery->status) ? 'selected' : '';?>>ACTIVO</option>
            <option value="INACTIVE" <?php echo 'INACTIVE' === strtoupper($cemetery->status) ? 'selected' : '';?>>INACTIVO</option>
        </select>
    </div>
    <div class="form__field">
        <label for="cemetery_image" class="form__label">Imagen</label>
        <input type="file" class="form__input form__input--file" id="cemetery_image" name="cemetery_image[]" multiple accept="image/*">
        <!-- <input type="file" class="form__input form__input--file" id="cemetery_image" name="cemetery_image"> -->
    </div>

    <?php if($flag){ ?>
        <?php if(0 !== count($differentImages)){ ?>
            <p class="form__text">Imágenes actuales:</p>
            <div class="form__image">
            <?php foreach($differentImages as $differentImage){ ?>
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/cemeteries/'.$differentImage.'.webp'; ?>" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/cemeteries/'.$differentImage.'.png'; ?>" type="image/png">
                    <img src="<?php echo $_ENV['HOST'].'/public/build/img/cemeteries/'.$differentImage.'.png'; ?>" alt="Imagen del cementerio">
                </picture>
            <?php } ?>
            </div>
        <?php }?>
    <?php } else{ ?>
        <?php if(isset($cemetery->currentImage) && !empty($cemetery->currentImage)){ ?>
            <p class="form__text">Imagen actual:</p>
            <div class="form__image">
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/cemeteries/'.$cemetery->currentImage.'.webp'; ?>" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/cemeteries/'.$cemetery->currentImage.'.png'; ?>" type="image/png">
                    <img src="<?php echo $_ENV['HOST'].'/public/build/img/cemeteries/'.$cemetery->currentImage.'.png'; ?>" alt="Imagen del cementerio">
                </picture>
            </div>
        <?php }?>
    <?php } ?>

</fieldset>

<fieldset class="form__fieldset">
    <legend for="cemetery_tags" class="form__legend">Información adicional del cementerio</legend>
    <div class="form__field">
        <label class="form__label" for="category">Categoría</label>
        <select class="form__select" id="category" name="category_id">
            <option value="">- Seleccionar -</option>
            <?php foreach($categories as $category){ ?>
                <option value="<?php echo $category->id;?>" <?php echo ($category->id===$cemetery->category_id) ? 'selected' : ''; ?>><?php echo $category->visible_name;?></option>
            <?php }?>
        </select>
    </div>
    <div class="form__field">
        <label class="form__label" for="caracteristics">Características (separadas por coma)</label>
        <input type="text" class="form__input" id="cemetery_tags" placeholder="Ejemplo: Ubicación, Propio, Externo">
        <div id="tags" class="form__list"></div>
        <input type="hidden" name="tags" value="<?php echo $cemetery->tags??'';?>">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend for="cemetery_video" class="form__legend">Video del cementerio</legend>
    <div class="form__field">
        <div class="form__icon-container">
            <div class="form__icon">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input type="text" class="form__input--socials" name="cemetery_networks[youtube]" placeholder="YouTube" value="<?php echo $networks->youtube??'';?>">
        </div>
    </div>
</fieldset>