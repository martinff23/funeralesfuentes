<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <p class="auth__text">Coloca tu nueva contraseña</p>

    <?php
        require_once __DIR__.'/../templates/alerts.php';    
    ?>

    <form method="POST" class="form">
        <div class="form__field">
        <label class="form__label" for="password">Nueva contraseña</label>
            <div class="password-wrapper">
            <input type="password" class="form__input" placeholder="Tu nueva contraseña" id="password" name="password">
                <button type="button" class="toggle-password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <div class="form__field">
            <label class="form__label" for="password">Repetir nueva contraseña</label>
            <div class="password-wrapper">
            <input type="password" class="form__input" placeholder="Repetir nueva contraseña" id="password2" name="password2">
                <button type="button" class="toggle-password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <input type="submit" class="form__submit" value="Actualizar contraseña">
    </form>
    <div class="actions">
    <a href="/login" class="actions__link">¿Ya tienes una cuenta? Iniciar sesión</a>
        <a href="/register" class="actions__link">¿Aún no tienes una cuenta? Crea una</a>
    </div>
</main>