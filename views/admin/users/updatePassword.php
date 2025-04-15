<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <p class="auth__text">Fuiste inscrito en el sistema por un administrador, por lo tanto es necesario que actualices tu contraseña para poder usar el sistema de Funerales Fuentes. Una vez que concluyas el proceso de actualización, tu sesión se cerrará y deberás iniciarla con tus nuevas credenciales.</p>

    <!-- <div class="user-options__button-container">
        <a class="user-options__button" href="/user/menu">
            <i class="fa-solid fa-circle-arrow-left"></i>
            Volver
        </a>
    </div> -->

    <?php
        require_once __DIR__.'/../../templates/alerts.php';
    ?>

    <form method="POST" class="form" enctype="multipart/form-data">
        <div class="form__field">
            <label class="form__label" for="password">Nueva contraseña</label>
            <div class="password-wrapper">
            <input type="password" class="form__input" placeholder="Nueva contraseña" id="password" name="password">
                <button type="button" class="toggle-password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <div class="form__field">
            <label class="form__label" for="password2">Repetir nueva contraseña</label>
            <div class="password-wrapper">
            <input type="password" class="form__input" placeholder="Repetir nueva contraseña" id="password2" name="password2">
                <button type="button" class="toggle-password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <input type="submit" class="form__submit" value="Cambiar contraseña">
    </form>
</main>