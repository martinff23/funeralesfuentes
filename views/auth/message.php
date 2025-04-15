<main class="auth">
    <h2 class="auth__heading"><?php echo $title;?></h2>
    <?php $destiny = str_contains($_SERVER['HTTP_REFERER'], 'employees') ? "employees" : "others"; ?>
    <?php if(isAdmin()){ ?>
        <a class="dashboard__button" href="<?php echo '/dashboard/users/'.$destiny; ?>">
            <i class="fa-solid fa-circle-arrow-left"></i>
            Volver
        </a>
        <p class="auth__text">
            Es necesario que el usuario confirme su cuenta. Hemos enviado las instrucciones a su correo electrónico registrado para continuar con el proceso.
        </p>
    <?php } else { ?>
        <p class="auth__text">
            Es necesario confirmar tu cuenta. Hemos enviado las instrucciones por correo electrónico para continuar con el proceso. Puedes cerrar esta pestaña.
        </p>
    <?php } ?>
</main>