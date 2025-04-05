<fieldset class="form__fieldset">
    <legend class="form__legend">Información del servicio</legend>
    <div class="form__field">
        <label for="service_name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="service_name" name="service_name" placeholder="Nombre del servicio" value="<?php echo $service->service_name??'';?>">
    </div>
    <div class="form__field">
        <label for="service_description" class="form__label">Descripción</label>
        <input type="text" class="form__input" id="service_description" name="service_description" placeholder="Descripción del servicio" value="<?php echo $service->service_description??'';?>">
    </div>
    <div class="form__field">
        <label for="service_cost" class="form__label">Costo</label>
        <input type="text" class="form__input" id="service_cost" name="service_cost" placeholder="Costo del servicio" value="<?php echo $service->service_cost??'';?>">
    </div>
    <div class="form__field">
        <label for="service_image" class="form__label">Imagen</label>
        <input type="file" class="form__input form__input--file" id="service_image" name="service_image[]" multiple accept="image/*">
        <!-- <input type="file" class="form__input form__input--file" id="service_image" name="service_image"> -->
    </div>

    <?php if($flag){ ?>
        <?php if(0 !== count($differentImages)){ ?>
            <p class="form__text">Imágenes actuales:</p>
            <div class="form__image">
            <?php foreach($differentImages as $differentImage){ ?>
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'].'/build/img/services/'.$differentImage.'.webp'; ?>" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'].'/build/img/services/'.$differentImage.'.png'; ?>" type="image/png">
                    <img src="<?php echo $_ENV['HOST'].'/build/img/services/'.$differentImage.'.png'; ?>" alt="Imagen del servicio">
                </picture>
            <?php } ?>
            </div>
        <?php }?>
    <?php } else{ ?>
        <?php if(isset($service->currentImage) && !empty($service->currentImage)){ ?>
            <p class="form__text">Imagen actual:</p>
            <div class="form__image">
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'].'/build/img/services/'.$service->currentImage.'.webp'; ?>" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'].'/build/img/services/'.$service->currentImage.'.png'; ?>" type="image/png">
                    <img src="<?php echo $_ENV['HOST'].'/build/img/services/'.$service->currentImage.'.png'; ?>" alt="Imagen del servicio">
                </picture>
            </div>
        <?php }?>
    <?php } ?>

</fieldset>

<fieldset class="form__fieldset">
    <legend for="service_tags" class="form__legend">Información adicional del servicio</legend>
    <div class="form__field">
        <label class="form__label" for="category">Categoría</label>
        <select class="form__select" id="category" name="category_id">
            <option value="">- Seleccionar -</option>
            <?php foreach($categories as $category){ ?>
                <option value="<?php echo $category->id;?>" <?php echo ($category->id===$service->category_id) ? 'selected' : ''; ?>><?php echo $category->visible_name;?></option>
            <?php }?>
        </select>
    </div>
    <div class="form__field">
        <label class="form__label" for="caracteristics">Características (separadas por coma)</label>
        <input type="text" class="form__input" id="service_tags" placeholder="Ejemplo: Decoración, Asesoría, Apoyo">
        <div id="tags" class="form__list"></div>
        <input type="hidden" name="tags" value="<?php echo $service->tags??'';?>">
    </div>
</fieldset>