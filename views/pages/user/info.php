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
            <label class="form__label" for="name">Nombre</label>
            <input type="text" class="form__input" placeholder="Tu nombre" id="name" name="name" value="<?php echo $info->name?>">
        </div>
        <div class="form__field">
            <label class="form__label" for="f_name">Apellido(s)</label>
            <input type="text" class="form__input" placeholder="Tu(s) apellido(s)" id="f_name" name="f_name" value="<?php echo $info->f_name?>">
        </div>
        <div class="form__field">
            <label class="form__label" for="telephone">Teléfono</label>
            <input type="telephone" class="form__input" placeholder="Tu teléfono" id="telephone" name="telephone" value="<?php echo $info->telephone?>">
        </div>
        <div class="form__field">
            <label class="form__label" for="birthday">Cumpleaños</label>
            <input type="date" class="form__input" placeholder="Tu cumpleaños" id="birthday" name="birthday" value="<?php echo $info->birthday?>">
        </div>
        <input type="submit" class="form__submit" value="Actualizar información">
    </form>
</main>