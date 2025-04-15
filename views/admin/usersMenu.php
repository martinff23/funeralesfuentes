<!-- <h3 class="intranet-menu__date" id="date-info"><span class="spinner" id="spinner"></span>Cargando información...</h3> -->
<h3 class="intranet-menu__date" id="date-info"></h3>

    <div class="intranet-options">
    <h3 class="intranet-menu__title">Menú de registro de usuarios</h3>
        <div class="intranet-options__usgrid">
            <a href="/dashboard/users/employees" class="intranet-options__link <?php echo currentPage('/dashboard/users/employees');?>">
                <i class="fa-solid fa-cross intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Colaboradores</span>
            </a>
            <a href="/dashboard/users/others" class="intranet-options__link <?php echo currentPage('/dashboard/users/others');?>">
                <i class="fa-solid fa-users intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Otros usuarios</span>
            </a>
        </div>
    </div>