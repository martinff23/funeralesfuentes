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
            <p class="header__text">Vivir para servir, servir para vivir</p>
            <p class="header__text header__text--slogan">Nunca estarás solx</p>
            <?php if(!isAuth()){ ?>
                <a href="/register" class="header__button">Quiero tener una cuenta</a>
            <?php }  ?>
        </div>
    </div>
</header>
<div class="bar">
    <div class="bar__content">
        <a href="/"><h2 class="bar__logo">FUNERALES FUENTES</h2></a>
        <nav class="nav">
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
        </nav>
    </div>
</div>