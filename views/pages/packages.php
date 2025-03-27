<main class="page-main">
    <h2 class="page-main__heading"><?php echo $title;?></h2>
    <p class="page-main__description">Conoce los paquetes que ofrecemos en Funerales Fuentes</p>

    <div class="packages__grid">
    <?php foreach($packages as $package){ ?>
        <?php $services = explode(",",$package->services);?>
        <?php $complements = explode(",",$package->complements);?>
        <div class="package">
            <h1 class="package__name"><?php echo $package->package_name;?></h1>
            <p class="package__description"><?php echo $package->package_description;?></p>
            <ul class="package__list">
                <li class="package__list-element"><?php echo $package->coffin;?></li>
                <li class="package__list-element"><?php echo $package->urn;?></li>
            <?php foreach($services as $service) { ?>
                <li class="package__list-element"><?php echo $service;?></li>
            <?php } ?>
            <?php foreach($complements as $complement) { ?>
                <li class="package__list-element"><?php echo $complement;?></li>
            <?php } ?>
                <li class="package__list-element"><?php echo $package->chapel;?></li>
                <li class="package__list-element"><?php echo $package->hearse;?></li>
            </ul>
            <p class="package__price">$<?php echo number_format($package->package_price);?> MXN</p>
            <input type="button" class="package__contact" value="Me interesa este paquete" data-id="<?php echo $package->id;?>">
        </div>
    <?php } ?>
    </div>
</main>