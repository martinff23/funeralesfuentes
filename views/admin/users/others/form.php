<div class="form__field">
    <label class="form__label" for="name">Nombre</label>
    <input type="text" class="form__input" placeholder="Tu nombre" id="name" name="name" value="<?php echo $us->name?>">
</div>
<div class="form__field">
    <label class="form__label" for="f_name">Apellido(s)</label>
    <input type="text" class="form__input" placeholder="Tu(s) apellido(s)" id="f_name" name="f_name" value="<?php echo $us->f_name?>">
</div>
<?php if("CR" === strtoupper($template)){ ?>
    <div class="form__field">
        <label class="form__label" for="email">Correo electrónico</label>
        <input type="email" class="form__input" placeholder="Tu correo electrónico" id="email" name="email" value="<?php echo $us->email?>">
    </div>
<?php } ?>
<div class="form__field">
    <label class="form__label" for="telephone">Teléfono</label>
    <input type="tel" class="form__input" placeholder="Tu teléfono" id="telephone" name="telephone" value="<?php echo $us->telephone?>">
</div>
<?php if("CR" === strtoupper($template)){ ?>
    <div class="form__field">
        <label class="form__label" for="password">Contraseña</label>
        <div class="password-wrapper">
            <input type="password" class="form__input" placeholder="Tu contraseña" id="password" name="password">
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
    <label for="role" class="form__label">Rol del usuario</label>
    <select class="form__input" id="role" name="role">
        <option value="NONE" <?php echo empty($file->route) ? 'selected' : '';?>>- SELECCIONA UN ROL -</option>
        <option value="admin" <?php echo 'ADMIN' === getUserRole() ? 'selected' : '';?>>Administrador</option>
        <option value="user" <?php echo 'USER' === getUserRole() ? 'selected' : '';?>>Usuario</option>
    </select>
</div>
<div class="form__field">
    <label for="user_image" class="form__label">Fotografía</label>
    <input type="file" class="form__input form__input--file" id="user_image" name="user_image">
</div>