<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <p class="auth__text">Recupera el acceso a tu cuenta en Funerales Fuentes</p>

    <?php
        require_once __DIR__.'/../templates/alerts.php';    
    ?>

    <form method="POST" class="form" action="/forgot">
        <div class="form__field">
            <label class="form__label" for="email">Correo electrónico</label>
            <input type="email" class="form__input" placeholder="Tu correo electrónico" id="email" name="email">
        </div>
        <input type="submit" class="form__submit" value="Enviar instrucciones">
    </form>
    <div class="actions">
    <a href="/login" class="actions__link">¿Ya tienes una cuenta? Iniciar sesión</a>
        <a href="/register" class="actions__link">¿Aún no tienes una cuenta? Crea una</a>
    </div>
</main>