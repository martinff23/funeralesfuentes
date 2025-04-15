<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <?php if(isAuth() && isAdmin()){ ?>
            <a href="/dashboard/users" class="dashboard__link <?php echo currentPage('/users'); echo currentPage('/employees'); echo currentPage('/others');?>">
                <i class="fa-solid fa-id-card dashboard__icon"></i>
                <span class="dashboard__menu-text">Registro de usuarios</span>
            </a>
            <a href="/dashboard/workElements" class="dashboard__link <?php echo currentPage('/workElements'); echo currentPage('/products'); echo currentPage('/services'); echo currentPage('/complements'); echo currentPage('/branches'); echo currentPage('/chapels'); echo currentPage('/hearses'); echo currentPage('/cemeteries'); echo currentPage('/crematories');?>">
                <i class="fa-solid fa-screwdriver-wrench dashboard__icon"></i>
                <span class="dashboard__menu-text">Elementos de trabajo</span>
            </a>
            <a href="/dashboard/recordElements" class="dashboard__link <?php echo currentPage('/recordElements'); echo currentPage('/opscountries'); echo currentPage('/identifications'); echo currentPage('/relations'); echo currentPage('/jobroles');?>">
                <i class="fa-solid fa-filter dashboard__icon"></i>
                <span class="dashboard__menu-text">Elementos de registro</span>
            </a>
            <a href="/dashboard/packages" class="dashboard__link <?php echo currentPage('/packages');?>">
                <i class="fa-solid fa-box-open dashboard__icon"></i>
                <span class="dashboard__menu-text">Registro de paquetes</span>
            </a>
            <a href="/dashboard/files" class="dashboard__link <?php echo currentPage('/files');?>">
                <i class="fa-solid fa-file dashboard__icon"></i>
                <span class="dashboard__menu-text">Registro de archivos</span>
            </a>
            <a href="/dashboard/alliMenu" class="dashboard__link <?php echo currentPage('/alliMenu'); echo currentPage('/alliances'); echo currentPage('/specialprograms');?>">
                <i class="fa-solid fa-people-arrows dashboard__icon"></i>
                <span class="dashboard__menu-text">Registro de convenios</span>
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