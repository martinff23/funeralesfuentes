<div class="bar">
    <div class="bar__content">
        <a href="/"><h2 class="bar__logo">FUNERALES FUENTES</h2></a>
        <nav class="nav">
            <ul class="nav__list">
                <!-- Nosotros -->
                <li class="nav__item">
                    <a href="/about" class="nav__toggle <?php echo currentPageBool('/about') ? 'nav__link--current' : ''; ?>">Nosotros</a>
                </li>

                <!-- Oferta (padre activo si uno de los hijos está activo) -->
                <li class="nav__item <?php echo currentPageBool('/products') || currentPageBool('/services') || currentPageBool('/hearses') ? 'nav__item--active' : ''; ?>">
                    <button class="nav__toggle <?php echo currentPageBool('/products') || currentPageBool('/services') || currentPageBool('/hearses') ? 'nav__link--current' : ''; ?>">
                        Oferta <span class="nav__arrow">▾</span>
                    </button>
                    <ul class="nav__dropdown">
                        <li><a href="/products" class="<?php echo currentPageBool('/products') ? 'nav__dropdown--current' : ''; ?>">Productos</a></li>
                        <li><a href="/services" class="<?php echo currentPageBool('/services') ? 'nav__dropdown--current' : ''; ?>">Servicios</a></li>
                        <li><a href="/hearses" class="<?php echo currentPageBool('/hearses') ? 'nav__dropdown--current' : ''; ?>">Carrozas</a></li>
                    </ul>
                </li>

                <!-- Instalaciones -->
                <li class="nav__item <?php echo currentPageBool('/branches') || currentPageBool('/chapels') || currentPageBool('/cemeteries') || currentPageBool('/crematories') ? 'nav__item--active' : ''; ?>">
                    <button class="nav__toggle <?php echo currentPageBool('/branches') || currentPageBool('/chapels') || currentPageBool('/cemeteries') || currentPageBool('/crematories') ? 'nav__link--current' : ''; ?>">
                        Instalaciones <span class="nav__arrow">&#9662;</span>
                    </button>
                    <ul class="nav__dropdown">
                        <li><a href="/branches" class="<?php echo currentPageBool('/branches') ? 'nav__dropdown--current' : ''; ?>">Sucursales</a></li>
                        <li><a href="/chapels" class="<?php echo currentPageBool('/chapels') ? 'nav__dropdown--current' : ''; ?>">Capillas</a></li>
                        <li><a href="/cemeteries" class="<?php echo currentPageBool('/cemeteries') ? 'nav__dropdown--current' : ''; ?>">Cementerios</a></li>
                        <li><a href="/crematories" class="<?php echo currentPageBool('/crematories') ? 'nav__dropdown--current' : ''; ?>">Crematorios</a></li>
                    </ul>
                </li>

                <!-- Cotiza -->
                <!-- <li class="nav__item">
                    <a href="/cotization" class="nav__toggle <?php echo currentPageBool('/cotization') ? 'nav__link--current' : ''; ?>">Cotiza</a>
                </li> -->

                <!-- Crea cuenta -->
                <?php if(!isAuth()){ ?>
                    <li class="nav__item">
                        <a href="/register" class="nav__toggle <?php echo currentPageBool('/register') ? 'nav__link--current' : ''; ?>">Crea cuenta</a>
                    </li>
                    <li class="nav__item">
                        <a href="/login" class="nav__toggle <?php echo currentPageBool('/login') ? 'nav__link--current' : ''; ?>">Inicia sesión</a>
                    </li>
                <?php } else { ?>
                    <li class="nav__item">
                        <a href="/logout" class="nav__toggle <?php echo currentPageBool('/logout') ? 'nav__link--current' : ''; ?>">Cerrar sesión</a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>