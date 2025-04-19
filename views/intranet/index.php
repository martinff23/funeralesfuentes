<!-- <h3 class="intranet-menu__date" id="date-info"><span class="spinner" id="spinner"></span>Cargando información...</h3> -->
<h3 class="intranet-menu__date" id="date-info"></h3>
<h1 class="intranet-menu__heading" id="user-greeting"><?php echo 'Hola, '.$user->name.'!';?></h1>

    <div class="intranet-menu__banner-container">
    <h3 class="intranet-menu__title">Anuncios</h3>
        <div class="intranet-menu__news-banner" id="news-banner">
            <div class="intranet-menu__news-content">
                🔔 Aviso: El próximo lunes habrá junta general. | 🎉 ¡Felicidades a todos los cumpleañeros de esta semana! | 📢 Recuerda actualizar tu información en el sistema.
            </div>
        </div>
    </div>

    <div class="intranet-menu__birthdays-container">
    <h3 class="intranet-menu__title">Próximos cumpleaños</h3>
        <table class="intranet-menu__birthdays" id="birthdays-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- Se llenará dinámicamente -->
            </tbody>
        </table>
    </div>

    <div class="intranet-options">
    <h3 class="intranet-menu__title">Enlaces útiles</h3>
    <p class="intranet-menu__title-text">Recursos humanos</p>
        <div class="intranet-options__grid">
            <a href="/dashboard/intranet/hr/attendance" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/hr/attendance');?>">
                <i class="fa-solid fa-clipboard-user intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Registrar asistencia</span>
            </a>
            <a href="/dashboard/intranet/hr/culture" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/hr/culture');?>">
                <i class="fa-solid fa-people-group intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Cultura empresarial</span>
            </a>
            <a href="/dashboard/intranet/hr/activities" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/hr/activities');?>">
                <i class="fa-solid fa-list-ol intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Actividades</span>
            </a>
            <a href="/dashboard/intranet/hr/permises" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/hr/permises');?>">
                <i class="fa-solid fa-hand intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Permisos</span>
            </a>
            <a href="/dashboard/intranet/hr/slips" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/hr/slips');?>">
                <i class="fa-solid fa-money-check-dollar intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Recibos de nómina</span>
            </a>
            <a href="/dashboard/intranet/hr/policies" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/hr/policies');?>">
                <i class="fa-solid fa-building-shield intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Políticas internas</span>
            </a>
            <a href="/dashboard/intranet/hr/rules" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/hr/rules');?>">
                <i class="fa-solid fa-handshake intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Reglamentos</span>
            </a>
            <a href="/dashboard/intranet/hr/compliance" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/hr/compliance');?>">
                <i class="fa-solid fa-phone intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Quejas y reportes</span>
            </a>
            <a href="/dashboard/intranet/hr/directory" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/hr/directory');?>">
                <i class="fa-solid fa-sitemap intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Directorio</span>
            </a>
            <a href="/dashboard/intranet/hr/jobs" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/hr/jobs');?>">
                <i class="fa-solid fa-briefcase intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Vacantes</span>
            </a>
        </div>
    </div>

    <div class="intranet-options">
    <p class="intranet-menu__title-text">Gestión documental</p>
        <div class="intranet-options__grid">
            <a href="/dashboard/intranet/docs/contract" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/docs/contract');?>">
                <i class="fa-solid fa-file-signature intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Contrato laboral</span>
            </a>
            <a href="/dashboard/intranet/docs/docs" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/docs/docs');?>">
                <i class="fa-solid fa-file intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Mis documentos</span>
            </a>
            <a href="/dashboard/intranet/docs/officialdocs" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/docs/officialdocs');?>">
                <i class="fa-solid fa-folder-open intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Documentos oficiales</span>
            </a>
            <a href="/dashboard/intranet/docs/officialimgs" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/docs/officialimgs');?>">
                <i class="fa-solid fa-images intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Imágenes oficiales</span>
            </a>
            <a href="/dashboard/intranet/docs/archive" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/docs/archive');?>">
                <i class="fa-solid fa-folder-tree intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Archivo</span>
            </a>
        </div>
    </div>

    <div class="intranet-options">
    <p class="intranet-menu__title-text">Solicitudes y servicios</p>
        <div class="intranet-options__grid">
            <a href="/dashboard/intranet/requests/it" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/requests/it');?>">
                <i class="fa-solid fa-headset intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Servicios IT</span>
            </a>
            <a href="/dashboard/intranet/requests/software" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/requests/software');?>">
                <i class="fa-solid fa-floppy-disk intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Software</span>
            </a>
            <a href="/dashboard/intranet/requests/extras" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/requests/extras');?>">
                <i class="fa-solid fa-pencil intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Materiales</span>
            </a>
            <a href="/dashboard/intranet/requests/internal" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/requests/internal');?>">
                <i class="fa-solid fa-screwdriver-wrench intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Solicitudes internas</span>
            </a>
            <a href="/dashboard/intranet/requests/trip" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/requests/trip');?>">
                <i class="fa-solid fa-plane-departure intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Viajes</span>
            </a>
        </div>
    </div>

    <div class="intranet-options">
    <p class="intranet-menu__title-text">Capacitación y desarrollo</p>
        <div class="intranet-options__grid">
            <a href="/dashboard/intranet/training/evaluation" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/training/evaluation');?>">
                <i class="fa-solid fa-people-arrows intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Evaluación</span>
            </a>
            <a href="/dashboard/intranet/training/courses" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/training/courses');?>">
                <i class="fa-solid fa-person-chalkboard intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Cursos internos</span>
            </a>
            <a href="/dashboard/intranet/training/procesos" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/training/procesos');?>">
                <i class="fa-solid fa-gears intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Procesos</span>
            </a>
            <a href="/dashboard/intranet/training/manuals" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/training/manuals');?>">
                <i class="fa-solid fa-book intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Manuales</span>
            </a>
            <a href="/dashboard/intranet/training/certificates" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/training/certificates');?>">
                <i class="fa-solid fa-certificate intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Certificados</span>
            </a>
        </div>
    </div>

    <div class="intranet-options">
    <p class="intranet-menu__title-text">Comunidad interna</p>
        <div class="intranet-options__grid">
            <a href="/dashboard/intranet/comunity/latest" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/comunity/latest');?>">
                <i class="fa-solid fa-volume-high intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Comunicaciones</span>
            </a>
            <a href="/dashboard/intranet/comunity/forum" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/comunity/forum');?>">
                <i class="fa-solid fa-comments intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Foro</span>
            </a>
            <a href="/dashboard/intranet/comunity/recognition" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/comunity/recognition');?>">
                <i class="fa-solid fa-award intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Reconocimientos</span>
            </a>
            <a href="/dashboard/intranet/comunity/surveys" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/comunity/surveys');?>">
                <i class="fa-solid fa-square-poll-vertical intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Encuestas</span>
            </a>
            <a href="/dashboard/intranet/comunity/suggestions" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/comunity/suggestions');?>">
                <i class="fa-solid fa-comment intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Sugerencias</span>
            </a>
        </div>
    </div>

    <div class="intranet-options">
    <p class="intranet-menu__title-text">Administración del perfil</p>
        <div class="intranet-options__grid">
            <a href="/dashboard/intranet/admin/adjust" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/admin/adjust');?>">
                <i class="fa-solid fa-gear intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Ajustes</span>
            </a>
            <a href="/dashboard/intranet/admin/activity" class="intranet-options__link <?php echo currentPage('/dashboard/intranet/admin/activity');?>">
                <i class="fa-solid fa-chart-line intranet-options__icon"></i>
                <span class="intranet-options__menu-text">Registro de actividad</span>
            </a>
        </div>
    </div>