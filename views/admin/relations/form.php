<fieldset class="form__fieldset">
    <legend class="form__legend">Información de la relación de contacto</legend>
    <div class="form__field">
        <label for="name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="name" name="name" placeholder="Nombre de la relación de contacto" value="<?php echo $relation->name??'';?>">
    </div>
    <div class="form__field">
        <label for="visual_name" class="form__label">Nombre visual</label>
        <input type="text" class="form__input" id="visual_name" name="visual_name" placeholder="Nombre visual de la relación de contacto" value="<?php echo $relation->visual_name??'';?>">
    </div>

</fieldset>