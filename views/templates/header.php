<header class="header">
    <div class="header__container">
        <nav class="header__nav">

            <?php if(isAuth()){ ?>
                <?php if(isAdmin()){ ?>
                    <div class="header__form">
                        <picture>
                            <source srcset="<?php echo $_ENV['HOST'].'/build/img/users/'.$user->image.'.webp'; ?>" type="image/webp">
                            <source srcset="<?php echo $_ENV['HOST'].'/build/img/users/'.$user->image.'.png'; ?>" type="image/png">
                            <img class="header__user-image" onerror="this.style.display='none'" loading="lazy" width="20" height="20" src="<?php echo $_ENV['HOST'].'/build/img/users/'.$user->image.'.png'; ?>" alt="us">
                        </picture>
                        <a href="/user/menu" class="header__link"><?php echo $_SESSION['name']; ?></a>
                    </div>
                    <a href="/dashboard/start" class="header__link">Panel administración</a>
                <?php } else if(isEmployee()){ ?>
                    <div class="header__form">
                        <picture>
                            <source srcset="<?php echo $_ENV['HOST'].'/build/img/users/'.$user->image.'.webp'; ?>" type="image/webp">
                            <source srcset="<?php echo $_ENV['HOST'].'/build/img/users/'.$user->image.'.png'; ?>" type="image/png">
                            <img class="header__user-image" onerror="this.style.display='none'" loading="lazy" width="20" height="20" src="<?php echo $_ENV['HOST'].'/build/img/users/'.$user->image.'.png'; ?>" alt="us">
                        </picture>
                        <a href="/user/menu" class="header__link"><?php echo $_SESSION['name']; ?></a>
                    </div>
                    <a href="/dashboard/start" class="header__link">Intranet</a>
                <?php } else{ ?>
                    <div class="header__form">
                        <picture>
                            <source srcset="<?php echo $_ENV['HOST'].'/build/img/users/'.$user->image.'.webp'; ?>" type="image/webp">
                            <source srcset="<?php echo $_ENV['HOST'].'/build/img/users/'.$user->image.'.png'; ?>" type="image/png">
                            <img class="header__user-image" onerror="this.style.display='none'" loading="lazy" width="20" height="20" src="<?php echo $_ENV['HOST'].'/build/img/users/'.$user->image.'.png'; ?>" alt="us">
                        </picture>
                        <a href="/user/menu" class="header__link"><?php echo $_SESSION['name']; ?></a>
                    </div>
                <?php } ?>
                <form action="/logout" method="POST" class="header__form">
                    <input type="submit" value="Cerrar sesión" class="header__submit">
                </form>
            <?php } else { ?>
                <a href="/register" class="header__link">Regístrate</a>
                <a href="/login" class="header__link">Iniciar sesión</a>
            <?php } ?>
        </nav>
        <div class="header__content">
            <a href="/">
                <h1 class="header__logo">Funerales Fuentes</h1>
            </a>
            <p class="header__text">Conmemoramos la vida dignificando la muerte</p>
            <!-- <p class="header__text header__text--slogan">Conmemoramos la vida dignificando la muerte</p> -->
            <?php if(!isAuth()){ ?>
                <a href="/register" class="header__button">Quiero tener una cuenta</a>
            <?php }  ?>
        </div>
    </div>
</header>
<div class="bar">
    <div class="bar__content">
        <a href="/"><h2 class="bar__logo">FUNERALES FUENTES</h2></a>
        <!-- <nav class="nav">
            <a href="/about" class="nav__link <?php echo currentPageBool('/about') ? 'nav__link--current' : ''; ?>">Nosotros</a>
            <a href="/packages" class="nav__link <?php echo currentPageBool('/packages') ? 'nav__link--current' : ''; ?>">Paquetes</a>
            <a href="/products" class="nav__link <?php echo currentPageBool('/products') ? 'nav__link--current' : ''; ?>">Productos</a>
            <a href="/services" class="nav__link <?php echo currentPageBool('/services') ? 'nav__link--current' : ''; ?>">Servicios</a>
            <a href="/chapels" class="nav__link <?php echo currentPageBool('/chapels') ? 'nav__link--current' : ''; ?>">Capillas</a>
            <a href="/hearses" class="nav__link <?php echo currentPageBool('/hearses') ? 'nav__link--current' : ''; ?>">Carrozas</a>
            <a href="/cemeteries" class="nav__link <?php echo currentPageBool('/cemeteries') ? 'nav__link--current' : ''; ?>">Cementerios</a>
            <a href="/crematories" class="nav__link <?php echo currentPageBool('/crematories') ? 'nav__link--current' : ''; ?>">Crematorios</a>
            <a href="/cotization" class="nav__link <?php echo currentPageBool('/cotization') ? 'nav__link--current' : ''; ?>">Cotiza</a>
            <?php if(!isAuth()){ ?>
                <a href="/register" class="nav__link <?php echo currentPageBool('/register') ? 'nav__link--current' : ''; ?>">Crea cuenta</a>
            <?php } ?>
        </nav> -->
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
                <li class="nav__item">
                    <a href="/cotization" class="nav__toggle <?php echo currentPageBool('/cotization') ? 'nav__link--current' : ''; ?>">Cotiza</a>
                </li>

                <!-- Crea cuenta -->
                <?php if(!isAuth()){ ?>
                    <li class="nav__item">
                        <a href="/register" class="nav__toggle <?php echo currentPageBool('/register') ? 'nav__link--current' : ''; ?>">Crea cuenta</a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

    </div>
</div>