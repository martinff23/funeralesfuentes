<fieldset class="form__fieldset">
    <legend class="form__legend">Información del crematorio</legend>
    <div class="form__field">
        <label for="crematory_name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="crematory_name" name="crematory_name" placeholder="Nombre del crematorio" value="<?php echo $crematory->crematory_name??'';?>">
    </div>
    <div class="form__field">
        <label for="crematory_description" class="form__label">Descripción</label>
        <input type="text" class="form__input" id="crematory_description" name="crematory_description" placeholder="Descripción del crematorio" value="<?php echo $crematory->crematory_description??'';?>">
    </div>
    <div class="form__field">
        <label for="crematory_cost" class="form__label">Costo</label>
        <input type="text" class="form__input" id="crematory_cost" name="crematory_cost" placeholder="Costo del crematorio" value="<?php echo $crematory->crematory_cost??'';?>">
    </div>
    <div class="form__field">
        <label for="crematory_image" class="form__label">Imagen</label>
        <input type="file" class="form__input form__input--file" id="crematory_image" name="crematory_image[]" multiple accept="image/*">
        <!-- <input type="file" class="form__input form__input--file" id="crematory_image" name="crematory_image"> -->
    </div>

    <?php if(isset($crematory->currentImage)) {?>
        <p class="form__text">Imagen actual:</p>
        <div class="form__image">
            <?php if($flag){ ?>
                <?php foreach($differentImages as $differentImage){ ?>
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/crematories/'.$differentImage.'.webp'; ?>" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/crematories/'.$differentImage.'.png'; ?>" type="image/png">
                        <img src="<?php echo $_ENV['HOST'].'/build/img/crematories/'.$differentImage.'.png'; ?>" alt="Imagen del crematorio">
                    </picture>
                <?php } ?>
            <?php } else{ ?>
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'].'/build/img/crematories/'.$crematory->currentImage.'.webp'; ?>" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'].'/build/img/crematories/'.$crematory->currentImage.'.png'; ?>" type="image/png">
                    <img src="<?php echo $_ENV['HOST'].'/build/img/crematories/'.$crematory->currentImage.'.png'; ?>" alt="Imagen del crematorio">
                </picture>
            <?php } ?>
        </div>
    <?php }?>

</fieldset>

<fieldset class="form__fieldset">
    <legend for="crematory_tags" class="form__legend">Información adicional del crematorio</legend>
    <div class="form__field">
        <label class="form__label" for="category">Categoría</label>
        <select class="form__select" id="category" name="category_id">
            <option value="">- Seleccionar -</option>
            <?php foreach($categories as $category){ ?>
                <option value="<?php echo $category->id;?>" <?php echo ($category->id===$crematory->category_id) ? 'selected' : ''; ?>><?php echo $category->visible_name;?></option>
            <?php }?>
        </select>
    </div>
    <div class="form__field">
        <label class="form__label" for="caracteristics">Características (separadas por coma)</label>
        <input type="text" class="form__input" id="crematory_tags" placeholder="Ejemplo: Velación, Acompañamiento, Ubicación">
        <div id="tags" class="form__list"></div>
        <input type="hidden" name="tags" value="<?php echo $crematory->tags??'';?>">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend for="crematory_video" class="form__legend">Video del crematorio</legend>
    <div class="form__field">
        <div class="form__icon-container">
            <div class="form__icon">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input type="text" class="form__input--socials" name="crematory_networks[youtube]" placeholder="YouTube" value="<?php echo $networks->youtube??'';?>">
        </div>
    </div>
</fieldset>