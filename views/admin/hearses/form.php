<fieldset class="form__fieldset">
    <legend class="form__legend">Información de la carroza</legend>
    <div class="form__field">
        <label for="hearse_name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="hearse_name" name="hearse_name" placeholder="Nombre de la carroza" value="<?php echo $hearse->hearse_name??'';?>">
    </div>
    <div class="form__field">
        <label for="hearse_description" class="form__label">Descripción</label>
        <input type="text" class="form__input" id="hearse_description" name="hearse_description" placeholder="Descripción de la carroza" value="<?php echo $hearse->hearse_description??'';?>">
    </div>
    <div class="form__field">
        <label for="hearse_cost" class="form__label">Costo</label>
        <input type="text" class="form__input" id="hearse_cost" name="hearse_cost" placeholder="Costo de la carroza" value="<?php echo $hearse->hearse_cost??'';?>">
    </div>
    <div class="form__field">
        <label for="hearse_image" class="form__label">Imagen</label>
        <input type="file" class="form__input form__input--file" id="hearse_image" name="hearse_image[]" multiple accept="image/*">
        <!-- <input type="file" class="form__input form__input--file" id="hearse_image" name="hearse_image"> -->
    </div>

    <?php if(isset($hearse->currentImage)) {?>
        <p class="form__text">Imagen actual:</p>
        <div class="form__image">
            <?php if($flag){ ?>
                <?php foreach($differentImages as $differentImage){ ?>
                    <picture>
                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/hearses/'.$differentImage.'.webp'; ?>" type="image/webp">
                        <source srcset="<?php echo $_ENV['HOST'].'/build/img/hearses/'.$differentImage.'.png'; ?>" type="image/png">
                        <img src="<?php echo $_ENV['HOST'].'/build/img/hearses/'.$differentImage.'.png'; ?>" alt="Imagen de la carroza">
                    </picture>
                <?php } ?>
            <?php } else{ ?>
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'].'/build/img/hearses/'.$hearse->currentImage.'.webp'; ?>" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'].'/build/img/hearses/'.$hearse->currentImage.'.png'; ?>" type="image/png">
                    <img src="<?php echo $_ENV['HOST'].'/build/img/hearses/'.$hearse->currentImage.'.png'; ?>" alt="Imagen de la carroza">
                </picture>
            <?php } ?>
        </div>
    <?php }?>

</fieldset>

<fieldset class="form__fieldset">
    <legend for="hearse_tags" class="form__legend">Información adicional de la carroza</legend>
    <div class="form__field">
        <label class="form__label" for="category">Categoría</label>
        <select class="form__select" id="category" name="category_id">
            <option value="">- Seleccionar -</option>
            <?php foreach($categories as $category){ ?>
                <option value="<?php echo $category->id;?>" <?php echo ($category->id===$hearse->category_id) ? 'selected' : ''; ?>><?php echo $category->visible_name;?></option>
            <?php }?>
        </select>
    </div>
    <div class="form__field">
        <label class="form__label" for="caracteristics">Características (separadas por coma)</label>
        <input type="text" class="form__input" id="hearse_tags" placeholder="Ejemplo: Ataúd, Caoba, Biodegradable">
        <div id="tags" class="form__list"></div>
        <input type="hidden" name="tags" value="<?php echo $hearse->tags??'';?>">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend for="hearse_video" class="form__legend">Video de la carroza</legend>
    <div class="form__field">
        <div class="form__icon-container">
            <div class="form__icon">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input type="text" class="form__input--socials" name="hearse_networks[youtube]" placeholder="YouTube" value="<?php echo $networks->youtube??'';?>">
        </div>
    </div>
</fieldset>