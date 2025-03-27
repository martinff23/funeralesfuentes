<header class="dashboard__header">
    <div class="dashboard__header-grid">
        <a href="/">
            <h2 class="dashboard__logo">FUNERALES FUENTES</h2>
        </a>
        <nav class="dashboard__nav">
            <div class="header__form">
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'].'/build/img/users/'.$user->image.'.webp'; ?>" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'].'/build/img/users/'.$user->image.'.png'; ?>" type="image/png">
                    <img class="header__user-image" onerror="this.style.display='none'" loading="lazy" width="20" height="20" src="<?php echo $_ENV['HOST'].'/build/img/users/'.$user->image.'.png'; ?>" alt="us">
                </picture>
                <a href="/user/menu" class="header__link"><?php echo $_SESSION['name']; ?></a>
                <form action="/logout" method="POST" class="dashboard__formlogout">
                    <input type="submit" value="Cerrar sesión" class="dashboard__submit--logout">
                </form>
            </div>
        </nav>
    </div>
</header>