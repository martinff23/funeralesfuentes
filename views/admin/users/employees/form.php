<fieldset class="form__fieldset">
    <legend class="form__legend">Información del colaborador</legend>
    <div class="form__field">
        <label class="form__label" for="name">Nombre</label>
        <input type="text" class="form__input" placeholder="Nombre del colaborador" id="name" name="name" value="<?php echo $us->name?>">
    </div>
    <div class="form__field">
        <label class="form__label" for="f_name">Apellido(s)</label>
        <input type="text" class="form__input" placeholder="Apellido(s) del colaborador" id="f_name" name="f_name" value="<?php echo $us->f_name?>">
    </div>
    <div class="form__field">
        <label class="form__label" for="telephone">Teléfono</label>
        <input type="tel" class="form__input" placeholder="Teléfono del colaborador" id="telephone" name="telephone" value="<?php echo $us->telephone?>">
    </div>
    <div class="form__field">
        <label for="gender" class="form__label">Género</label>
        <select class="form__input" id="gender" name="gender">
            <option value="NONE" <?php echo 'NONE' === strtoupper($employee->gender) ? 'selected' : '';?>>- SELECCIONA UNA OPCIÓN -</option>
            <option value="male" <?php echo 'MALE' === strtoupper($employee->gender) ? 'selected' : '';?>>Hombre</option>
            <option value="female" <?php echo 'FEMALE' === strtoupper($employee->gender) ? 'selected' : '';?>>Mujer</option>
            <option value="nonbinary" <?php echo 'NONBINARY' === strtoupper($employee->gender) ? 'selected' : '';?>>No binario</option>
        </select>
    </div>
    <div class="form__field">
        <label for="disability" class="form__label">¿Tiene alguna discapacidad?</label>
        <select class="form__input" id="disability" name="disability">
            <option value="NONE" <?php echo 'NONE' === $employee->disability ? 'selected' : '';?>>- SELECCIONA UNA OPCIÓN -</option>
            <option value="0" <?php echo '0' === $employee->disability ? 'selected' : '';?>>No</option>
            <option value="1" <?php echo '1' === $employee->disability ? 'selected' : '';?>>Si</option>
        </select>
    </div>
    <div class="form__field">
        <label for="movility_chance" class="form__label">Disponibilidad de cambiar de sede</label>
        <select class="form__input" id="movility_chance" name="movility_chance">
            <option value="NONE" <?php echo 'NONE' === $employee->movility_chance ? 'selected' : '';?>>- SELECCIONA UNA OPCIÓN -</option>
            <option value="0" <?php echo '0' === $employee->movility_chance ? 'selected' : '';?>>0%</option>
            <option value="5" <?php echo '5' === $employee->movility_chance ? 'selected' : '';?>>5%</option>
            <option value="10" <?php echo '10' === $employee->movility_chance ? 'selected' : '';?>>10%</option>
            <option value="15" <?php echo '15' === $employee->movility_chance ? 'selected' : '';?>>15%</option>
            <option value="20" <?php echo '20' === $employee->movility_chance ? 'selected' : '';?>>20%</option>
            <option value="25" <?php echo '25' === $employee->movility_chance ? 'selected' : '';?>>25%</option>
            <option value="30" <?php echo '30' === $employee->movility_chance ? 'selected' : '';?>>30%</option>
            <option value="35" <?php echo '35' === $employee->movility_chance ? 'selected' : '';?>>35%</option>
            <option value="40" <?php echo '40' === $employee->movility_chance ? 'selected' : '';?>>40%</option>
            <option value="45" <?php echo '45' === $employee->movility_chance ? 'selected' : '';?>>45%</option>
            <option value="50" <?php echo '50' === $employee->movility_chance ? 'selected' : '';?>>50%</option>
            <option value="55" <?php echo '55' === $employee->movility_chance ? 'selected' : '';?>>55%</option>
            <option value="60" <?php echo '60' === $employee->movility_chance ? 'selected' : '';?>>60%</option>
            <option value="65" <?php echo '65' === $employee->movility_chance ? 'selected' : '';?>>65%</option>
            <option value="70" <?php echo '70' === $employee->movility_chance ? 'selected' : '';?>>70%</option>
            <option value="75" <?php echo '75' === $employee->movility_chance ? 'selected' : '';?>>75%</option>
            <option value="80" <?php echo '80' === $employee->movility_chance ? 'selected' : '';?>>80%</option>
            <option value="85" <?php echo '85' === $employee->movility_chance ? 'selected' : '';?>>85%</option>
            <option value="90" <?php echo '90' === $employee->movility_chance ? 'selected' : '';?>>90%</option>
            <option value="95" <?php echo '95' === $employee->movility_chance ? 'selected' : '';?>>95%</option>
            <option value="100" <?php echo '100' === $employee->movility_chance ? 'selected' : '';?>>100%</option>
        </select>
    </div>
    <div class="form__field">
        <label for="special_program_id" class="form__label">¿Pertenece a algun programa especial?</label>
        <select class="form__input" id="special_program_id" name="special_program_id">
            <option value="NONE" <?php echo 'NONE' === $employee->special_program_id ? 'selected' : '';?>>- SELECCIONA UNA OPCIÓN -</option>
            <option value="0" <?php echo '0' === $employee->special_program_id ? 'selected' : '';?>>No pertenece</option>
            <?php foreach($programs as $program){ ?>
                <option value="<?php echo $program->id;?>" <?php echo $program->id === $employee->special_program_id ? 'selected' : '';?>><?php echo $program->visual_name;?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form__field">
        <label for="positionId" class="form__label">Posición laboral</label>
        <select class="form__input" id="positionId" name="positionId">
            <option value="NONE" <?php echo 'NONE' === $employee->positionId ? 'selected' : '';?>>- SELECCIONA UNA OPCIÓN -</option>
            <?php foreach($roles as $role){ ?>
                <option value="<?php echo $role->id;?>" <?php echo $role->id === $employee->positionId ? 'selected' : '';?>><?php echo $role->visual_name;?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form__field">
        <label for="branchId" class="form__label">Sucursal destino</label>
        <select class="form__input" id="branchId" name="branchId">
            <option value="NONE" <?php echo 'NONE' === $employee->branchId ? 'selected' : '';?>>- SELECCIONA UNA OPCIÓN -</option>
            <?php foreach($branches as $branch){ ?>
                <option value="<?php echo $branch->id;?>" <?php echo $branch->id === $employee->branchId ? 'selected' : '';?>><?php echo $branch->branch_name;?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form__field">
        <label class="form__label" for="start_date">Fecha de inicio</label>
        <input type="date" class="form__input" placeholder="Fecha de inicio" id="start_date" name="start_date" value="<?php echo $employee->start_date?>">
    </div>
</fieldset>
<fieldset class="form__fieldset">
    <legend class="form__legend">Identificación del colaborador</legend>
    <div class="form__field">
        <label for="identification_type" class="form__label">Tipo de identificación</label>
        <select class="form__input" id="identification_type" name="identification_type">
            <option value="NONE" <?php echo 'NONE' === $employee->identification_type ? 'selected' : '';?>>- SELECCIONA UNA OPCIÓN -</option>
            <?php foreach($identifications as $identification){ ?>
                <option value="<?php echo $identification->id;?>" <?php echo $identification->id === $employee->identification_type ? 'selected' : '';?>><?php echo $identification->visual_name;?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form__field">
        <label class="form__label" for="identification_value">Número de identificación</label>
        <input type="text" class="form__input" placeholder="Número de identificación del colaborador" id="identification_value" name="identification_value" value="<?php echo $employee->identification_value?>">
    </div>
    <div class="form__field">
        <label class="form__label" for="social_security_id">Número de seguridad social</label>
        <input type="text" class="form__input" placeholder="Número de seguridad social del colaborador" id="social_security_id" name="social_security_id" value="<?php echo $employee->social_security_id?>">
    </div>
</fieldset>
<fieldset class="form__fieldset">
    <legend class="form__legend">Contacto de emergencia del colaborador</legend>
    <div class="form__field">
        <label class="form__label" for="emergency_contact_name">Nombre</label>
        <input type="text" class="form__input" placeholder="Nombre del contacto de emergencia" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo $employee->emergency_contact_name?>">
    </div>
    <div class="form__field">
        <label class="form__label" for="emergency_contact">Teléfono</label>
        <input type="text" class="form__input" placeholder="Teléfono del contacto de emergencia" id="emergency_contact" name="emergency_contact" value="<?php echo $employee->emergency_contact?>">
    </div>
    <div class="form__field">
        <label for="emergency_contact_relation" class="form__label">Relación</label>
        <select class="form__input" id="emergency_contact_relation" name="emergency_contact_relation">
            <option value="NONE" <?php echo 'NONE' === $employee->emergency_contact_relation ? 'selected' : '';?>>- SELECCIONA UNA OPCIÓN -</option>
            <?php foreach($relations as $relation){ ?>
                <option value="<?php echo $relation->id;?>" <?php echo $relation->id === $employee->emergency_contact_relation ? 'selected' : '';?>><?php echo $relation->visual_name;?></option>
            <?php } ?>
        </select>
    </div>
</fieldset>
<fieldset class="form__fieldset">
    <legend class="form__legend">Cuenta del colaborador</legend>
    <?php if("CR" === strtoupper($template)){ ?>
        <div class="form__field">
            <label class="form__label" for="email">Correo electrónico</label>
            <input type="email" class="form__input" placeholder="Correo electrónico del colaborador" id="email" name="email" value="<?php echo $us->email?>">
        </div>
        <div class="form__field">
            <label class="form__label" for="password">Contraseña</label>
            <div class="password-wrapper">
                <input type="password" class="form__input" placeholder="Contraseña" id="password" name="password">
                <button type="button" class="toggle-password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <div class="form__field">
            <label class="form__label" for="password2">Repetir contraseña</label>
            <div class="password-wrapper">
                <input type="password" class="form__input" placeholder="Repetir contraseña" id="password2" name="password2">
                <button type="button" class="toggle-password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>    
    <?php } ?>
    <div class="form__field">
        <label for="user_image" class="form__label">Fotografía</label>
        <input type="file" class="form__input form__input--file" id="user_image" name="user_image">
    </div>
    <?php if(isset($us->currentImage) && !empty($us->currentImage)){ ?>
    <p class="form__text">Imagen actual:</p>
    <div class="form__image">
        <picture>
            <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/users/'.$us->currentImage.'.webp'; ?>" type="image/webp">
            <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/users/'.$us->currentImage.'.png'; ?>" type="image/png">
            <img src="<?php echo $_ENV['HOST'].'/public/build/img/users/'.$us->currentImage.'.png'; ?>" alt="Imagen del usuario">
        </picture>
    </div>
    <?php }?>
</fieldset>