<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title;?></h2>

    <picture>
        <img class="error__image" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'].'/build/img/error/'.$selectedImage; ?>" alt="Imagen del error">
    </picture>

    <div style="width: 300px; margin: 5rem auto 0 auto; display: block;">
        <a href="/" class="form__submit">Volver al inicio</a>
    </div>

</main>