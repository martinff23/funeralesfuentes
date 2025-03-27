<fieldset class="form__fieldset">
    <legend class="form__legend">Información de la capilla</legend>
    <div class="form__field">
        <label for="chapel_name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="chapel_name" name="chapel_name" placeholder="Nombre de la capilla" value="<?php echo $chapel->chapel_name??'';?>">
    </div>
    <div class="form__field">
        <label for="chapel_description" class="form__label">Descripción</label>
        <input type="text" class="form__input" id="chapel_description" name="chapel_description" placeholder="Descripción de la capilla" value="<?php echo $chapel->chapel_description??'';?>">
    </div>
    <div class="form__field">
        <label for="chapel_cost" class="form__label">Costo</label>
        <input type="text" class="form__input" id="chapel_cost" name="chapel_cost" placeholder="Costo de la capilla" value="<?php echo $chapel->chapel_cost??'';?>">
    </div>
    <div class="form__field">
        <label for="chapel_image" class="form__label">Imagen</label>
        <input type="file" class="form__input form__input--file" id="chapel_image" name="chapel_image">
    </div>

    <?php if(isset($chapel->currentImage)) {?>
        <p class="form__text">Imagen actual:</p>
        <div class="form__image">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'].'/build/img/chapels/'.$chapel->currentImage.'.webp'; ?>" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'].'/build/img/chapels/'.$chapel->currentImage.'.png'; ?>" type="image/png">
                <img src="<?php echo $_ENV['HOST'].'/build/img/chapels/'.$chapel->currentImage.'.png'; ?>" alt="Imagen de la capilla">
            </picture>
        </div>
    <?php }?>

</fieldset>

<fieldset class="form__fieldset">
    <legend for="chapel_tags" class="form__legend">Información adicional de la capilla</legend>
    <div class="form__field">
        <label class="form__label" for="category">Categoría</label>
        <select class="form__select" id="category" name="category_id">
            <option value="">- Seleccionar -</option>
            <?php foreach($categories as $category){ ?>
                <option value="<?php echo $category->id;?>" <?php echo ($category->id===$chapel->category) ? 'selected' : ''; ?>><?php echo $category->visible_name;?></option>
            <?php }?>
        </select>
    </div>
    <div class="form__field">
        <label class="form__label" for="caracteristics">Características (separadas por coma)</label>
        <input type="text" class="form__input" id="chapel_tags" placeholder="Ejemplo: Velación, Acompañamiento, Ubicación">
        <div id="tags" class="form__list"></div>
        <input type="hidden" name="tags" value="<?php echo $chapel->tags??'';?>">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend for="chapel_video" class="form__legend">Video de la capilla</legend>
    <div class="form__field">
        <div class="form__icon-container">
            <div class="form__icon">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input type="text" class="form__input--socials" name="chapel_networks[youtube]" placeholder="YouTube" value="<?php echo $networks->youtube??'';?>">
        </div>
    </div>
</fieldset>