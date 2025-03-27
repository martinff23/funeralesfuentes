<main class="about">
    <h2 class="about__heading"><?php echo $title;?></h2>

    <div class="user-options">
        <div class="user-options__grid">
            <a href="/user/info" class="user-options__link <?php echo currentPage('/user/info');?>">
                <i class="fa-solid fa-circle-info user-options__icon"></i>
                <span class="user-options__menu-text">Información de usuario</span>
            </a>
            <a href="/user/email" class="user-options__link <?php echo currentPage('/user/email');?>">
                <i class="fa-solid fa-at user-options__icon"></i>
                <span class="user-options__menu-text">Cambiar correo electrónico</span>
            </a>
            <a href="/user/password" class="user-options__link <?php echo currentPage('/user/password');?>">
                <i class="fa-solid fa-key user-options__icon"></i>
                <span class="user-options__menu-text">Cambiar contraseña</span>
            </a>
            <a href="/user/photo" class="user-options__link <?php echo currentPage('/user/photo');?>">
                <i class="fa-solid fa-image user-options__icon"></i>
                <span class="user-options__menu-text">Cambiar fotografía</span>
            </a>
            <a href="/user/plans" class="user-options__link <?php echo currentPage('/user/plans');?>">
                <i class="fa-solid fa-hand-holding-heart user-options__icon"></i>
                <span class="user-options__menu-text">Mis planes</span>
            </a>
            <a href="/user/digitickets" class="user-options__link <?php echo currentPage('/user/digitickets');?>">
                <i class="fa-solid fa-ticket user-options__icon"></i>
                <span class="user-options__menu-text">Mis boletos digitales</span>
            </a>
            <a href="/user/history" class="user-options__link <?php echo currentPage('/user/history');?>">
                <i class="fa-solid fa-receipt user-options__icon"></i>
                <span class="user-options__menu-text">Historial de transacciones</span>
            </a>
            <a href="/user/subscriptions" class="user-options__link <?php echo currentPage('/user/subscriptions');?>">
                <i class="fa-solid fa-newspaper user-options__icon"></i>
                <span class="user-options__menu-text">Gestionar suscripciones</span>
            </a>
            <a href="/user/delete" class="user-options__link <?php echo currentPage('/user/delete');?>">
                <i class="fa-solid fa-user-xmark user-options__icon"></i>
                <span class="user-options__menu-text">Borrar cuenta</span>
            </a>
        </div>
    </div>

</main>