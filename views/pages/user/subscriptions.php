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
            <label class="form__label" for="coffin_search">Promociones</label>
            <select name="acceptsPromos" id="acceptsPromos" class="container_product form__select">
                <option value="none">- Selecciona una opción -</option>
                <option value="0" <?php if("0"===$user->acceptsPromos){ echo "selected";} ?>>NO deseo recibir promociones</option>
                <option value="1" <?php if("1"===$user->acceptsPromos){ echo "selected";} ?>>SI, deseo recibir promociones</option>
            </select>
        </div>
        <div class="form__field">
            <label class="form__label" for="urn_search">Publicidad</label>
            <select name="acceptsMarketing" id="acceptsMarketing" class="container_product form__select">
                <option value="none">- Selecciona una opción -</option>
                <option value="0" <?php if("0"===$user->acceptsMarketing){ echo "selected";} ?>>NO deseo recibir publicidad</option>
                <option value="1" <?php if("1"===$user->acceptsMarketing){ echo "selected";} ?>>SI, deseo recibir publicidad</option>
            </select>
        </div>

        <input type="submit" class="form__submit" value="Actualizar preferencias">
    </form>
</main>