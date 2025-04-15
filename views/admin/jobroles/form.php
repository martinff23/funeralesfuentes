<fieldset class="form__fieldset">
    <legend class="form__legend">Información de la posición laboral</legend>
    <div class="form__field">
        <label for="name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="name" name="name" placeholder="Nombre de la posición" value="<?php echo $jobrole->name??'';?>">
    </div>
    <div class="form__field">
        <label for="visual_name" class="form__label">Nombre visual</label>
        <input type="text" class="form__input" id="visual_name" name="visual_name" placeholder="Nombre visual de la posición" value="<?php echo $jobrole->visual_name??'';?>">
    </div>
    <div class="form__field">
        <label for="min_salary" class="form__label">Banda mínima</label>
        <input type="text" class="form__input" id="min_salary" name="min_salary" placeholder="Valor banda mínima de la posición" value="<?php echo $jobrole->min_salary??'';?>">
    </div>
    <div class="form__field">
        <label for="max_salary" class="form__label">Banda máxima</label>
        <input type="text" class="form__input" id="max_salary" name="max_salary" placeholder="Valor banda máxima de la posición" value="<?php echo $jobrole->max_salary??'';?>">
    </div>

</fieldset>