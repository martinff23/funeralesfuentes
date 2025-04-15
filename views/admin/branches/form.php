<fieldset class="form__fieldset">
    <legend class="form__legend">Información de la sucursal</legend>
    <div class="form__field">
        <label for="branch_name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="branch_name" name="branch_name" placeholder="Nombre de la sucursal" value="<?php echo $branch->branch_name??'';?>">
    </div>
    <div class="form__field">
        <label for="branch_description" class="form__label">Descripción</label>
        <input type="text" class="form__input" id="branch_description" name="branch_description" placeholder="Descripción de la sucursal" value="<?php echo $branch->branch_description??'';?>">
    </div>
    <div class="form__field">
        <label for="branch_ISO" class="form__label">ISO</label>
        <input type="text" class="form__input" id="branch_ISO" name="branch_ISO" placeholder="ISO de la sucursal" value="<?php echo $branch->branch_ISO??'';?>">
    </div>
    <div class="form__field">
        <label for="address" class="form__label">Dirección</label>
        <input type="text" class="form__input" id="address" name="address" placeholder="Dirección de la sucursal" value="<?php echo $branch->address??'';?>">
    </div>
    <div class="form__field">
        <label for="telephone" class="form__label">Teléfono</label>
        <input type="tel" class="form__input" id="telephone" name="telephone" placeholder="Teléfono de la sucursal" value="<?php echo $branch->telephone??'';?>">
    </div>
    <div class="form__field">
        <label for="latitude" class="form__label">Latitud</label>
        <input type="text" class="form__input" id="latitude" name="latitude" placeholder="Latitud" value="<?php echo $branch->latitude??'';?>">
    </div>
    <div class="form__field">
        <label for="longitude" class="form__label">Longitud</label>
        <input type="text" class="form__input" id="longitude" name="longitude" placeholder="Longitud" value="<?php echo $branch->longitude??'';?>">
    </div>
    <div class="form__field">
        <label for="open_date" class="form__label">Fecha apertura</label>
        <input type="date" class="form__input" id="open_date" name="open_date" placeholder="Longitud" value="<?php echo $branch->open_date??'';?>">
    </div>
    <div class="form__field">
        <label for="status" class="form__label">Estado</label>
        <select class="form__input" id="status" name="status">
            <option value="NONE" <?php echo empty($branch->status) ? 'selected' : '';?>>- SELECCIONA UN ESTADO -</option>
            <option value="ACTIVE" <?php echo 'ACTIVE' === strtoupper($branch->status) ? 'selected' : '';?>>ACTIVA</option>
            <option value="INACTIVE" <?php echo 'INACTIVE' === strtoupper($branch->status) ? 'selected' : '';?>>INACTIVA</option>
        </select>
    </div>
    <div class="form__field">
        <label for="branch_image" class="form__label">Imagen</label>
        <input type="file" class="form__input form__input--file" id="branch_image" name="branch_image[]" multiple accept="image/*">
        <!-- <input type="file" class="form__input form__input--file" id="branch_image" name="branch_image"> -->
    </div>

    <?php if($flag){ ?>
        <?php if(0 !== count($differentImages)){ ?>
            <p class="form__text">Imágenes actuales:</p>
            <div class="form__image">
            <?php foreach($differentImages as $differentImage){ ?>
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/branches/'.$differentImage.'.webp'; ?>" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/branches/'.$differentImage.'.png'; ?>" type="image/png">
                    <img src="<?php echo $_ENV['HOST'].'/public/build/img/branches/'.$differentImage.'.png'; ?>" alt="Imagen de la sucursal o punto de venta">
                </picture>
            <?php } ?>
            </div>
        <?php }?>
    <?php } else{ ?>
        <?php if(isset($branch->currentImage) && !empty($branch->currentImage)){ ?>
            <p class="form__text">Imagen actual:</p>
            <div class="form__image">
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/branches/'.$branch->currentImage.'.webp'; ?>" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/branches/'.$branch->currentImage.'.png'; ?>" type="image/png">
                    <img src="<?php echo $_ENV['HOST'].'/public/build/img/branches/'.$branch->currentImage.'.png'; ?>" alt="Imagen de la sucursal o punto de venta">
                </picture>
            </div>
        <?php }?>
    <?php } ?>

</fieldset>

<fieldset class="form__fieldset">
    <legend for="branch_tags" class="form__legend">Información adicional del producto</legend>
    <div class="form__field">
        <label class="form__label" for="category">Categoría</label>
        <select class="form__select" id="category" name="category_id">
            <option value="">- Seleccionar -</option>
            <?php foreach($categories as $category){ ?>
                <option value="<?php echo $category->id;?>" <?php echo ($category->id===$branch->category_id) ? 'selected' : ''; ?>><?php echo $category->visible_name;?></option>
            <?php }?>
        </select>
    </div>
    <div class="form__field">
        <label class="form__label" for="caracteristics">Características (separadas por coma)</label>
        <input type="text" class="form__input" id="branch_tags" placeholder="Ejemplo: Ataúd, Caoba, Biodegradable">
        <div id="tags" class="form__list"></div>
        <input type="hidden" name="tags" value="<?php echo $branch->tags??'';?>">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend for="branch_video" class="form__legend">Video del producto</legend>
    <div class="form__field">
        <div class="form__icon-container">
            <div class="form__icon">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input type="text" class="form__input--socials" name="branch_networks[youtube]" placeholder="YouTube" value="<?php echo $networks->youtube??'';?>">
        </div>
    </div>
</fieldset>