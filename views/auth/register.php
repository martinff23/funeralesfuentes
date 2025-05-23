<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <p class="auth__text">Registrate para crear tu perfil en Funerales Fuentes</p>

    <?php
        require_once __DIR__.'/../templates/alerts.php';
    ?>

    <form method="POST" class="form" action="/register" enctype="multipart/form-data">
        <div class="form__field">
            <label class="form__label" for="name">Nombre</label>
            <input type="text" class="form__input" placeholder="Tu nombre" id="name" name="name" value="<?php echo $us->name?>">
        </div>
        <div class="form__field">
            <label class="form__label" for="f_name">Apellido(s)</label>
            <input type="text" class="form__input" placeholder="Tu(s) apellido(s)" id="f_name" name="f_name" value="<?php echo $us->f_name?>">
        </div>
        <div class="form__field">
            <label class="form__label" for="email">Correo electrónico</label>
            <input type="email" class="form__input" placeholder="Tu correo electrónico" id="email" name="email" value="<?php echo $us->email?>">
        </div>
        <div class="form__field">
            <label class="form__label" for="telephone">Teléfono</label>
            <input type="tel" class="form__input" placeholder="Tu teléfono" id="telephone" name="telephone" value="<?php echo $us->telephone?>">
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
        <div class="form__field">
            <label class="form__label" for="password2">Repetir contraseña</label>
            <div class="password-wrapper">
                <input type="password" class="form__input" placeholder="Repetir contraseña" id="password2" name="password2">
                <button type="button" class="toggle-password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <div class="form__field">
            <label for="user_image" class="form__label">Fotografía</label>
            <input type="file" class="form__input form__input--file" id="user_image" name="user_image">
        </div>
        <div class="g-recaptcha" data-sitekey=<?php echo $_ENV['CAP_KEY']?>></div>
        <input type="submit" class="form__submit" value="Crear cuenta">
    </form>
    <div class="actions">
        <a href="/login" class="actions__link">¿Ya tienes una cuenta? Iniciar sesión</a>
        <a href="/forgot" class="actions__link">¿Olvidaste tu contraseña? Recupérala</a>
    </div>
</main>