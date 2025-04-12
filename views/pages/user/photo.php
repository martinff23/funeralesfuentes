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

    <form class="form" method="POST" enctype="multipart/form-data">
        <div class="form__field">
            <label for="user_image" class="form__label">Imagen</label>
            <input type="file" class="form__input form__input--file" id="user_image" name="user_image">
        </div>

        <?php if(isset($user->currentImage) && !empty($user->currentImage)){ ?>
            <p class="form__text">Imagen actual:</p>
            <div class="form__image">
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/users/'.$user->currentImage.'.webp'; ?>" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'].'/public/build/img/users/'.$user->currentImage.'.png'; ?>" type="image/png">
                    <img src="<?php echo $_ENV['HOST'].'/public/build/img/users/'.$user->currentImage.'.png'; ?>" alt="Imagen del usuario">
                </picture>
            </div>
        <?php }?>

        <input type="submit" class="form__submit" value="Actualizar fotografía">
    </form>
</main>