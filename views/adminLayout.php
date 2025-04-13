<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUNERALES FUENTES</title>
    <link rel="icon" type="image/x-icon" href="/public/build/img/golden_ico.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/public/build/css/app.css">
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin="" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" /> -->
</head>
<body class="dashboard">
        <?php 
            include_once __DIR__ .'/templates/adminHeader.php';
        ?>
        <div class="dashboard__grid">
            <?php
                include_once __DIR__ .'/templates/adminSidebar.php';  
            ?>
            <main class="dashboard__content">
                <?php 
                    echo $content; 
                ?> 
            </main>
        </div>
    <!-- <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script> -->
    <script src="/public/build/js/main.min.js" defer></script>
</body>
</html>