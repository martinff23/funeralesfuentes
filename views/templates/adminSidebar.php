<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <a href="/dashboard/start" class="dashboard__link <?php echo currentPage('/start');?>">
            <i class="fa-solid fa-house dashboard__icon"></i>
            <span class="dashboard__menu-text">Inicio</span>
        </a>
        <?php if(isAuth() && isAdmin()){ ?>
            <a href="/dashboard/products" class="dashboard__link <?php echo currentPage('/products');?>">
                <i class="fa-solid fa-cross dashboard__icon"></i>
                <span class="dashboard__menu-text">Productos</span>
            </a>
            <a href="/dashboard/services" class="dashboard__link <?php echo currentPage('/services');?>">
                <i class="fa-solid fa-bell-concierge dashboard__icon"></i>
                <span class="dashboard__menu-text">Servicios</span>
            </a>
            <a href="/dashboard/complements" class="dashboard__link <?php echo currentPage('/complements');?>">
                <i class="fa-solid fa-square-plus dashboard__icon"></i>
                <span class="dashboard__menu-text">Extras</span>
            </a>
            <a href="/dashboard/chapels" class="dashboard__link <?php echo currentPage('/chapels');?>">
                <i class="fa-solid fa-hands-praying dashboard__icon"></i>
                <span class="dashboard__menu-text">Capillas</span>
            </a>
            <a href="/dashboard/hearses" class="dashboard__link <?php echo currentPage('/hearses');?>">
                <i class="fa-solid fa-car dashboard__icon"></i>
                <span class="dashboard__menu-text">Carrozas</span>
            </a>
            <a href="/dashboard/cemeteries" class="dashboard__link <?php echo currentPage('/cemeteries');?>">
                <i class="fa-solid fa-church dashboard__icon"></i>
                <span class="dashboard__menu-text">Cementerios</span>
            </a>
            <a href="/dashboard/crematories" class="dashboard__link <?php echo currentPage('/crematories');?>">
                <i class="fa-solid fa-fire-burner dashboard__icon"></i>
                <span class="dashboard__menu-text">Crematorios</span>
            </a>
            <a href="/dashboard/packages" class="dashboard__link <?php echo currentPage('/packages');?>">
                <i class="fa-solid fa-box-open dashboard__icon"></i>
                <span class="dashboard__menu-text">Paquetes</span>
            </a>
        <?php }?>
        <?php if(isAuth() && !isAdmin()){ ?>
            <a href="/dashboard/cotization" class="dashboard__link <?php echo currentPage('/cotization');?>">
                <i class="fa-solid fa-dollar-sign dashboard__icon"></i>
                <span class="dashboard__menu-text">Cotizaciones</span>
            </a>
            <!-- <a href="/dashboard/intranet" class="dashboard__link <?php echo currentPage('/intranet');?>">
                <i class="fa-solid fa-users dashboard__icon"></i>
                <span class="dashboard__menu-text">Intranet</span>
            </a> -->
        <?php }?>
    </nav>
</aside>