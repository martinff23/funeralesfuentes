<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <p class="auth__text">Registrate en Funerales Fuentes</p>

    <form class="form" action="">
        <div class="form__field">
            <label class="form__label" for="email">Correo electrónico</label>
            <input type="email" class="form__input" placeholder="Tu correo electrónico" id="email" name="email">
        </div>
        <div class="form__field">
            <label class="form__label" for="password">Contraseña</label>
            <input type="password" class="form__input" placeholder="Tu contraseña" id="password" name="password">
        </div>
        <input type="submit" class="form__submit" value="Iniciar sesión">
    </form>
    <div class="actions">
        <a href="/register" class="actions__link">¿Aún no tienes una cuenta? Crea una</a>
        <a href="/forgot" class="actions__link">¿Olvidaste tu contraseña? Recuperar contraseña</a>
    </div>
</main>