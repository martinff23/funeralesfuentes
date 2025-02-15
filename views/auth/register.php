<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <p class="auth__text">Registrate para crear tu perfil en Funerales Fuentes</p>

    <form class="form" action="">
        <div class="form__field">
            <label class="form__label" for="name">Nombre</label>
            <input type="text" class="form__input" placeholder="Tu nombre" id="name" name="name">
        </div>
        <div class="form__field">
            <label class="form__label" for="f_name">Apellido(s)</label>
            <input type="text" class="form__input" placeholder="Tu(s) apellido(s)" id="f_name" name="f_name">
        </div>
        <div class="form__field">
            <label class="form__label" for="email">Correo electrónico</label>
            <input type="email" class="form__input" placeholder="Tu correo electrónico" id="email" name="email">
        </div>
        <div class="form__field">
            <label class="form__label" for="password">Contraseña</label>
            <input type="password" class="form__input" placeholder="Tu contraseña" id="password" name="password">
        </div>
        <div class="form__field">
            <label class="form__label" for="password2">Repetir contraseña</label>
            <input type="password" class="form__input" placeholder="Repetir contraseña" id="password2" name="password2">
        </div>
        <input type="submit" class="form__submit" value="Crear cuenta">
    </form>
    <div class="actions">
        <a href="/login" class="actions__link">¿Ya tienes una cuenta? Iniciar sesión</a>
        <a href="/forgot" class="actions__link">¿Olvidaste tu contraseña? Recupérala</a>
    </div>
</main>