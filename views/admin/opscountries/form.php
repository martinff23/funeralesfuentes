<fieldset class="form__fieldset">
    <legend class="form__legend">Información del programa</legend>
    <div class="form__field">
        <label for="name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="name" name="name" placeholder="Nombre del programa" value="<?php echo $opscountry->name??'';?>">
    </div>
    <div class="form__field">
        <label for="visual_name" class="form__label">Nombre visual</label>
        <input type="text" class="form__input" id="visual_name" name="visual_name" placeholder="Nombre visual del programa" value="<?php echo $opscountry->visual_name??'';?>">
    </div>

</fieldset>