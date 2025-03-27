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
            <label class="form__label" for="current_email">Correo electrónico actual</label>
            <input type="email" class="form__input" placeholder="Tu correo electrónico actual" id="current_email" name="current_email" value="<?php echo $_POST['current_email'];?>">
        </div>
        <div class="form__field">
            <label class="form__label" for="email">Nuevo correo electrónico</label>
            <input type="email" class="form__input" placeholder="Tu nuevo correo electrónico" id="email" name="email" value="<?php echo $_POST['email'];?>">
        </div>
        <div class="form__field">
            <label class="form__label" for="email2">Confirmar nuevo correo electrónico</label>
            <input type="email" class="form__input" placeholder="Confirma tu nuevo correo electrónico" id="email2" name="email2" value="<?php echo $_POST['email2'];?>">
        </div>
        <input type="submit" class="form__submit" value="Cambiar correo electrónico">
    </form>
</main>