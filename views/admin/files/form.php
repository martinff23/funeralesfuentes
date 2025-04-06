<fieldset class="form__fieldset">
    <legend class="form__legend">Información del archivo</legend>
    <div class="form__field">
        <label for="file_route" class="form__label">Tipo de archivo</label>
        <select class="form__input" id="file_route" name="file_route">
            <option value="NONE" <?php echo empty($file->route) ? 'selected' : '';?>>- SELECCIONA UN TIPO -</option>
            <option value="error" <?php echo 'ERROR' === strtoupper($file->route) ? 'selected' : '';?>>IMAGENES DE ERROR</option>
        </select>
    </div>
    <div class="form__field">
        <label for="real_name" class="form__label">Nombre del archivo</label>
        <input type="text" class="form__input" id="real_name" name="real_name" placeholder="Nombre del archivo" value="<?php echo $file->real_name??'';?>" disabled>
    </div>
    <div class="form__field">
        <label for="file_image" class="form__label">Imagen</label>
        <input type="file" class="form__input form__input--file" id="file_image" name="file_image">
    </div>

    <?php if(isset($file->currentImage) && !empty($file->currentImage)){ ?>
        <p class="form__text">Imagen actual:</p>
        <div class="form__image">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'].'/build/img/'.$file->route.'/'.$file->currentImage.'.webp'; ?>" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'].'/build/img/'.$file->route.'/'.$file->currentImage.'.png'; ?>" type="image/png">
                <img src="<?php echo $_ENV['HOST'].'/build/img/'.$file->route.'/'.$file->currentImage.'.png'; ?>" alt="Imagen de la alianza">
            </picture>
        </div>
    <?php }?>

</fieldset>