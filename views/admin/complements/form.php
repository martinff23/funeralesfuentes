<fieldset class="form__fieldset">
    <legend class="form__legend">Información del extra</legend>
    <div class="form__field">
        <label for="complement_name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="complement_name" name="complement_name" placeholder="Nombre del extra" value="<?php echo $complement->complement_name??'';?>">
    </div>
    <div class="form__field">
        <label for="complement_description" class="form__label">Descripción</label>
        <input type="text" class="form__input" id="complement_description" name="complement_description" placeholder="Descripción del extra" value="<?php echo $complement->complement_description??'';?>">
    </div>
    <div class="form__field">
        <label for="complement_cost" class="form__label">Costo</label>
        <input type="text" class="form__input" id="complement_cost" name="complement_cost" placeholder="Costo del extra" value="<?php echo $complement->complement_cost??'';?>">
    </div>
    <div class="form__field">
        <label for="complement_image" class="form__label">Imagen</label>
        <input type="file" class="form__input form__input--file" id="complement_image" name="complement_image">
    </div>

    <?php if(isset($complement->currentImage)) {?>
        <p class="form__text">Imagen actual:</p>
        <div class="form__image">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'].'/build/img/complements/'.$complement->currentImage.'.webp'; ?>" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'].'/build/img/complements/'.$complement->currentImage.'.png'; ?>" type="image/png">
                <img src="<?php echo $_ENV['HOST'].'/build/img/complements/'.$complement->currentImage.'.png'; ?>" alt="Imagen del extra">
            </picture>
        </div>
    <?php }?>

</fieldset>

<fieldset class="form__fieldset">
    <legend for="complement_tags" class="form__legend">Información adicional del extra</legend>
    <div class="form__field">
        <label class="form__label" for="category">Categoría</label>
        <select class="form__select" id="category" name="category_id">
            <option value="">- Seleccionar -</option>
            <?php foreach($categories as $category){ ?>
                <option value="<?php echo $category->id;?>" <?php echo ($category->id===$complement->category) ? 'selected' : ''; ?>><?php echo $category->visible_name;?></option>
            <?php }?>
        </select>
    </div>
    <div class="form__field">
        <label class="form__label" for="caracteristics">Características (separadas por coma)</label>
        <input type="text" class="form__input" id="complement_tags" placeholder="Ejemplo: Flores, decoración, apoyo">
        <div id="tags" class="form__list"></div>
        <input type="hidden" name="tags" value="<?php echo $complement->tags??'';?>">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend for="complement_video" class="form__legend">Video del extra</legend>
    <div class="form__field">
        <div class="form__icon-container">
            <div class="form__icon">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input type="text" class="form__input--socials" name="complement_networks[youtube]" placeholder="YouTube" value="<?php echo $networks->youtube??'';?>">
        </div>
    </div>
</fieldset>