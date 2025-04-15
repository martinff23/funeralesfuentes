<fieldset class="form__fieldset">
    <legend class="form__legend">Información de la alianza</legend>
    <div class="form__field">
        <label for="alliance_name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="alliance_name" name="alliance_name" placeholder="Nombre de la empresa" value="<?php echo $alliance->business_name??'';?>">
    </div>
    <div class="form__field">
        <label for="alliance_status" class="form__label">Estado de la alianza</label>
        <select class="form__input" id="alliance_status" name="alliance_status">
            <option value="NONE" <?php echo empty($alliance->status) ? 'selected' : '';?>>- SELECCIONA UN ESTADO -</option>
            <option value="ACTIVE" <?php echo 'ACTIVE' === strtoupper($alliance->status) ? 'selected' : '';?>>ACTIVA</option>
            <option value="INACTIVE" <?php echo 'INACTIVE' === strtoupper($alliance->status) ? 'selected' : '';?>>INACTIVA</option>
        </select>
    </div>
    <div class="form__field">
        <label for="alliance_image" class="form__label">Imagen</label>
        <input type="file" class="form__input form__input--file" id="alliance_image" name="alliance_image">
    </div>

    <?php if(isset($alliance->currentImage) && !empty($alliance->currentImage)){ ?>
        <p class="form__text">Imagen actual:</p>
        <div class="form__image">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/alliances/'.$alliance->currentImage.'.webp'; ?>" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/alliances/'.$alliance->currentImage.'.png'; ?>" type="image/png">
                <img src="<?php echo $_ENV['HOST'].'/public/build/img/alliances/'.$alliance->currentImage.'.png'; ?>" alt="Imagen de la alianza">
            </picture>
        </div>
    <?php }?>

</fieldset>