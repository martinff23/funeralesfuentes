<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/users/others">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__form">
    <?php
        include_once __DIR__.'/../../templates/alerts.php';
    ?>

    <form class="form" method="POST" enctype="multipart/form-data">
        <?php $template = "ED"; ?>
        <?php include_once __DIR__.'/form.php'; ?>
        <input class="form__submit form__submit--register" type="submit" value="Actualizar usuario">
    </form>

</div>