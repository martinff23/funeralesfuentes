<fieldset class="form__fieldset">
    <legend class="form__legend">Información del programa</legend>
    <div class="form__field">
        <label for="name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="name" name="name" placeholder="Nombre de la identificación" value="<?php echo $identification->name??'';?>">
    </div>
    <div class="form__field">
        <label for="visual_name" class="form__label">Nombre visual</label>
        <input type="text" class="form__input" id="visual_name" name="visual_name" placeholder="Nombre visual de la identificación" value="<?php echo $identification->visual_name??'';?>">
    </div>
    <div class="form__field">
        <label for="country" class="form__label">País</label>
        <select class="form__input" id="country" name="country">
            <option value="NONE" <?php echo 'NONE' === $identification->country ? 'selected' : '';?>>- SELECCIONA UNA OPCIÓN -</option>
            <?php foreach($countries as $country){ ?>
                <option value="<?php echo $country->name;?>" <?php echo $country->name === $identification->country ? 'selected' : '';?>><?php echo $country->visual_name;?></option>
            <?php } ?>
        </select>
    </div>

</fieldset>