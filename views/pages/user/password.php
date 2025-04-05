<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>

    <div class="user-options__button-container">
        <a class="user-options__button" href="/user/menu">
            <i class="fa-solid fa-circle-arrow-left"></i>
            Volver
        </a>
    </div>

    <?php
        require_once __DIR__.'/../../templates/alerts.php';
    ?>

    <form method="POST" class="form" enctype="multipart/form-data">
        <div class="form__field">
            <label class="form__label" for="current_password">Contraseña actual</label>
            <div class="password-wrapper">
                <input type="password" class="form__input" placeholder="Tu contraseña actual" id="current_password" name="current_password">
                <button type="button" class="toggle-password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
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