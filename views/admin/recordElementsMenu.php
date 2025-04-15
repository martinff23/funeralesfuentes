<!-- <h3 class="intranet-menu__date" id="date-info"><span class="spinner" id="spinner"></span>Cargando información...</h3> -->
<h3 class="intranet-menu__date" id="date-info"></h3>

    <div class="intranet-options">
    <h3 class="intranet-menu__title">Menú de registro de elementos para ingresar usuarios</h3>
        <div class="intranet-options__usgrid">
            <a href="/dashboard/opscountries" class="intranet-options__link <?php echo currentPage('/opscountries');?>">
                <i class="fa-solid fa-globe intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Países</span>
            </a>
            <a href="/dashboard/identifications" class="intranet-options__link <?php echo currentPage('/identifications');?>">
                <i class="fa-solid fa-passport intranet-options__icon"></i>
                <span class="intranet-options__menu-text">IDs</span>
            </a>
            <a href="/dashboard/relations" class="intranet-options__link <?php echo currentPage('/relations');?>">
                <i class="fa-solid fa-link intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Relaciones</span>
            </a>
            <a href="/dashboard/jobroles" class="intranet-options__link <?php echo currentPage('/jobroles');?>">
                <i class="fa-solid fa-sitemap intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Roles</span>
            </a>
        </div>
    </div>