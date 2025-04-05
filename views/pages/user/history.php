<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title; ?></h2>
    
    <div class="user-options__button-container">
        <a class="user-options__button" href="/user/menu">
            <i class="fa-solid fa-circle-arrow-left"></i>
            Volver
        </a>
    </div>
    
    <?php if(0 === count($funerals)){ ?>
        <h3 class="page-element__no-elements">No cuentas con servicios en el sistema de Funerales Fuentes</h3>
    <?php } else { ?>
        <?php //Implementar lógica para mostrar los servicios y el modal para que al dar click podamos ver detalles ?>
    <?php }?>
</main>