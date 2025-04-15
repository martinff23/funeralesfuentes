<fieldset class="form__fieldset">
    <legend class="form__legend">Información del programa</legend>
    <div class="form__field">
        <label for="name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="name" name="name" placeholder="Nombre del programa" value="<?php echo $specialprogram->name??'';?>">
    </div>
    <div class="form__field">
        <label for="visual_name" class="form__label">Nombre visual</label>
        <input type="text" class="form__input" id="visual_name" name="visual_name" placeholder="Nombre visual del programa" value="<?php echo $specialprogram->visual_name??'';?>">
    </div>
    <div class="form__field">
        <label for="source" class="form__label">Fuente</label>
        <select class="form__input" id="source" name="source">
            <option value="NONE" <?php echo 'NONE' === $specialprogram->source ? 'selected' : '';?>>- SELECCIONA UNA OPCIÓN -</option>
            <option value="GOV" <?php echo 'GOV' === $specialprogram->source ? 'selected' : '';?>>Gobierno</option>
            <option value="PUB" <?php echo 'PUB' === $specialprogram->source ? 'selected' : '';?>>Otra institución pública</option>
            <option value="PRI" <?php echo 'PRI' === $specialprogram->source ? 'selected' : '';?>>Institución privada</option>
            <option value="ONG" <?php echo 'ONG' === $specialprogram->source ? 'selected' : '';?>>ONG</option>
            <option value="EDU" <?php echo 'EDU' === $specialprogram->source ? 'selected' : '';?>>Institución educativa</option>
        </select>
    </div>

</fieldset>