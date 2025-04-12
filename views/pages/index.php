<?php

use Model\Alliance;
use Model\Branch;
use Model\Category;
use Model\Cemetery;
use Model\Chapel;
use Model\Crematory;
use Model\Hearse;
use Model\Package;

    $title = 'Un mensaje de nuestro Director General...';
    include_once __DIR__.'/latestMessage.php';

    $title = '¿Qué hace a Funerales Fuentes?';
    $start = true;
    include_once __DIR__.'/about.php';
?>

<section class="summary">
    <div class="summary__grid">
        <div data-aos="zoom-in" class="summary__segment">
            <p class="summary__text summary__text--number"><?php echo number_format($yearsOfExperience); ?></p>
            <?php $yearsLegend = $yearsOfExperience > 1 ? "Años" : (0 === $yearsOfExperience ? "Años" : "Año"); ?>
            <p class="summary__text"><?php echo $yearsLegend; ?> de experiencia</p>
        </div>
        <div data-aos="zoom-in" class="summary__segment">
            <p class="summary__text summary__text--number"><?php echo number_format($totalBranches); ?></p>
            <?php $assetsLegend = $totalBranches > 1 ? "Activos" : (0 === $totalBranches ? "Activos" : "Activo"); ?>
            <p class="summary__text"><?php echo $assetsLegend; ?></p>
        </div>
        <div data-aos="zoom-in" class="summary__segment">
            <p class="summary__text summary__text--number"><?php echo number_format($totalEmployees); ?></p>
            <?php $collaboratorsLegend = $totalEmployees > 1 ? "Colaboradores" : (0 === $totalEmployees ? "Colaboradores" : "Colaborador"); ?>
            <p class="summary__text"><?php echo $collaboratorsLegend; ?></p>
        </div>
        <div data-aos="zoom-in" class="summary__segment">
            <!-- <p class="summary__text summary__text--number"><?php //echo number_format($totalJobs); ?></p> -->
            <p class="summary__text summary__text--number">+<?php echo number_format(1000); ?></p>
            <?php $jobsLegend = $totalJobs > 1 ? "Trabajos realizados" : (0 === $totalJobs ? "Trabajos realizados" : "Trabajo realizado"); ?>
            <p class="summary__text"><?php echo $jobsLegend; ?></p>
        </div>
    </div>
</section>

<?php
    $title = 'Paquetes de servicios funerarios';
    $packages = Package::all();
    if(count($packages) > 0){
        include_once __DIR__.'/packages.php';
    }
    
    $title = 'Nuestras sucursales y puntos de venta';
    $start = true;
    $branches = groupBranchesByCategory(Branch::all(), groupCategories(Category::allWhere('type','branch')));
    if(count($branches) > 0){
        include_once __DIR__.'/branches.php';
    }
    
    $title = 'Nuestras capillas de velación';
    $chapels = [];
    $start = true;
    $groupedChapels = groupChapelsByCategory(Chapel::all(), groupCategories(Category::allWhere('type','chapel')));
    if($groupedChapels || count($groupedChapels) > 0){
        foreach($groupedChapels['own'] as $groupedChapel){
            array_push($chapels, $groupedChapel);
        }
    }
    if(count($chapels) > 0){
        include_once __DIR__.'/chapels.php';
    }
    
    $title = 'Nuestras carrozas';
    $hearses = [];
    $start = true;
    $groupedHearses = groupHearsesByCategory(Hearse::all(), groupCategories(Category::allWhere('type','hearse')));
    if($groupedHearses || count($groupedHearses) > 0){
        foreach($groupedHearses['own'] as $groupedHearse){
            array_push($hearses, $groupedHearse);
        }
    }
    if(count($hearses) > 0){
        include_once __DIR__.'/hearses.php';
    }
    
    $title = 'Nuestros cementerios';
    $cemeteries = [];
    $start = true;
    $groupedCemeteries = groupCemeteriesByCategory(Cemetery::all(), groupCategories(Category::allWhere('type','cemetery')));
    if($groupedCemeteries || count($groupedCemeteries) > 0){
        foreach($groupedCemeteries['own'] as $groupedCemetery){
            array_push($cemeteries, $groupedCemetery);
        }
    }
    if(count($cemeteries) > 0){
        include_once __DIR__.'/cemeteries.php';
    }
    
    $title = 'Nuestros crematorios';
    $crematories = [];
    $start = true;
    $groupedCrematories = groupCrematoriesByCategory(Crematory::all(), groupCategories(Category::allWhere('type','crematory')));
    if($groupedCrematories || count($groupedCrematories) > 0){
        foreach($groupedCrematories['own'] as $groupedCrematory){
            array_push($crematories, $groupedCrematory);
        }
    }
    if(count($crematories) > 0){
        include_once __DIR__.'/crematories.php';
    }
?>

<?php $alliances = Alliance::allWhere('status', 'ACTIVE');?>

<?php if(count($alliances) > 0){ ?>

<h2 class="page-main__heading">Nuestras alianzas estratégicas</h2>

<div class="alliances-slider">
  <div class="alliances-track" id="alliancesTrack">
    <div class="alliances-logos">
      <?php foreach($alliances as $alliance){ ?>
        <?php /** @var \Model\Alliance $alliance */ ?>
        <img src="<?php echo $_ENV['HOST'].'/public/build/img/alliances/'.$alliance->image.'.png';?>" alt="<?php echo $alliance->business_name;?>">
      <?php } ?>
      <?php foreach($alliances as $alliance){ ?>
        <?php /** @var \Model\Alliance $alliance */ ?>
        <img src="<?php echo $_ENV['HOST'].'/public/build/img/alliances/'.$alliance->image.'.png';?>" alt="<?php echo $alliance->business_name;?>">
      <?php } ?>
      <?php foreach($alliances as $alliance){ ?>
        <?php /** @var \Model\Alliance $alliance */ ?>
        <img src="<?php echo $_ENV['HOST'].'/public/build/img/alliances/'.$alliance->image.'.png';?>" alt="<?php echo $alliance->business_name;?>">
      <?php } ?>
      <?php foreach($alliances as $alliance){ ?>
        <?php /** @var \Model\Alliance $alliance */ ?>
        <img src="<?php echo $_ENV['HOST'].'/public/build/img/alliances/'.$alliance->image.'.png';?>" alt="<?php echo $alliance->business_name;?>">
      <?php } ?>
      <?php foreach($alliances as $alliance){ ?>
        <?php /** @var \Model\Alliance $alliance */ ?>
        <img src="<?php echo $_ENV['HOST'].'/public/build/img/alliances/'.$alliance->image.'.png';?>" alt="<?php echo $alliance->business_name;?>">
      <?php } ?>
      <?php foreach($alliances as $alliance){ ?>
        <?php /** @var \Model\Alliance $alliance */ ?>
        <img src="<?php echo $_ENV['HOST'].'/public/build/img/alliances/'.$alliance->image.'.png';?>" alt="<?php echo $alliance->business_name;?>">
      <?php } ?>
      <?php foreach($alliances as $alliance){ ?>
        <?php /** @var \Model\Alliance $alliance */ ?>
        <img src="<?php echo $_ENV['HOST'].'/public/build/img/alliances/'.$alliance->image.'.png';?>" alt="<?php echo $alliance->business_name;?>">
      <?php } ?>
      <?php foreach($alliances as $alliance){ ?>
        <?php /** @var \Model\Alliance $alliance */ ?>
        <img src="<?php echo $_ENV['HOST'].'/public/build/img/alliances/'.$alliance->image.'.png';?>" alt="<?php echo $alliance->business_name;?>">
      <?php } ?>
      <?php foreach($alliances as $alliance){ ?>
        <?php /** @var \Model\Alliance $alliance */ ?>
        <img src="<?php echo $_ENV['HOST'].'/public/build/img/alliances/'.$alliance->image.'.png';?>" alt="<?php echo $alliance->business_name;?>">
      <?php } ?>
    </div>
  </div>
</div>

<?php } ?>

<h2 class="page-main__heading">Ubicaciones</h2>

<div class="map-container">
    <div id="map-legend" class="map-legend">
        <h4>Significado</h4>
        <p>Amplia o reduce el mapa para ver todas las ubicaciones</p>
        <ul>
            <li><img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png"> Sucursal fija</li>
            <li><img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-black.png"> Punto de venta</li>
            <li><img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png"> Capilla propia</li>
            <li><img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-orange.png"> Capilla externa</li>
            <li><img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png"> Cementerio propio</li>
            <li><img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-gold.png"> Cementerio externo</li>
            <li><img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-violet.png"> Crematorio propio</li>
            <li><img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-grey.png"> Crematorio externo</li>
        </ul>
    </div>
    
    <div id="map" class="map"></div>
</div>

<?php $title = "¿Quieres saber más de Funerales Fuentes?"; ?>

<?php if(!$user){ ?>
    <main class="auth">
    <h2 class="page-main__heading"><?php echo $title;?></h2>
    <p class="auth__text">Déjanos tus datos para contactarte</p>

    <?php
        require_once __DIR__.'/../templates/alerts.php';    
    ?>
    <form id="form_contact" class="form" method="POST" enctype="multipart/form-data">
        <div class="form__field">
            <label class="form__label" for="name">Nombre</label>
            <input type="text" class="form__input" placeholder="Tu nombre" id="name" name="name">
        </div>
        <div class="form__field">
            <label class="form__label" for="telephone">Teléfono celular (WhatsApp)</label>
            <input type="telephone" class="form__input" placeholder="Tu teléfono celular" id="telephone" name="telephone">
        </div>
        <div class="form__field">
            <label class="form__label" for="email">Correo electrónico</label>
            <input type="email" class="form__input" placeholder="Tu correo electrónico" id="email" name="email">
        </div>
        <input type="submit" class="form__submit" value="Contactarme">
    </form>
    <div class="actions">
        <a href="/register" class="actions__link">¿Quieres crear una cuenta? Click aquí</a>
        <a href="/login" class="actions__link">¿Ya tienes una cuenta? Inicia sesión</a>
    </div>
    </main>
<?php } ?>