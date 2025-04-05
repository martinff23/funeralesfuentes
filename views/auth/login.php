<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <p class="auth__text">Inicia sesión en Funerales Fuentes</p>

    <?php
        require_once __DIR__.'/../templates/alerts.php';    
    ?>

    <form method="POST" class="form" action="/login">
        <div class="form__field">
            <label class="form__label" for="email">Correo electrónico</label>
            <input type="email" class="form__input" placeholder="Tu correo electrónico" id="email" name="email">
        </div>
        <div class="form__field">
            <label class="form__label" for="password">Contraseña</label>
            <div class="password-wrapper">
                <input type="password" class="form__input" placeholder="Tu contraseña" id="password" name="password">
                <button type="button" class="toggle-password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <input type="submit" class="form__submit" value="Iniciar sesión">
    </form>
    <div class="actions">
        <a href="/register" class="actions__link">¿Aún no tienes una cuenta? Crea una</a>
        <a href="/forgot" class="actions__link">¿Olvidaste tu contraseña? Recupérala</a>
    </div>
</main>