<fieldset class="form__fieldset">
    <legend class="form__legend">Información del paquete</legend>
    <div class="form__field">
        <label for="package_name" class="form__label">Nombre</label>
        <input type="text" class="form__input" id="package_name" name="package_name" placeholder="Nombre del paquete" value="<?php echo $package->package_name??'';?>">
        <div id="name_tags_div" class="form__list"></div>
    </div>
    <div class="form__field">
        <label for="package_description" class="form__label">Descripción</label>
        <input type="text" class="form__input" id="package_description" name="package_description" placeholder="Descripción del paquete" value="<?php echo $package->package_description??'';?>">
        <div id="description_tags_div" class="form__list"></div>
    </div>
    <div class="form__field">
        <label for="package_image" class="form__label">Imagen</label>
        <input type="file" class="form__input form__input--file" id="package_image" name="package_image">
        <div id="image_tags_div" class="form__list"></div>
    </div>

    <?php if(isset($package->currentImage) && !empty($package->currentImage)){ ?>
        <p class="form__text">Imagen actual:</p>
        <div class="form__image">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'].'/build/img/packages/'.$package->currentImage.'.webp'; ?>" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'].'/build/img/packages/'.$package->currentImage.'.png'; ?>" type="image/png">
                <img src="<?php echo $_ENV['HOST'].'/build/img/packages/'.$package->currentImage.'.png'; ?>" alt="Imagen del paquete">
            </picture>
        </div>
    <?php }?>

    <div class="form__field">
        <label class="form__label" for="coffin_search">Ataúd</label>
        <div class="container_product">
            <input type="text" class="form__input" name="coffin_search" id="coffin_search" value="<?php echo $package->coffin??'';?>" placeholder="Nombre del ataúd" autocomplete="off" />
            <div id="coffins_dropdown" class="dropdown"></div>
        </div>
        <div id="coffin_tags_div" class="form__list"></div>
        <input type="hidden" name="coffin_id" value="<?php echo $package->coffin_id??'';?>">
    </div>
    <div class="form__field">
        <label class="form__label" for="urn_search">Urna</label>
        <div class="container_product">
            <input type="text" class="form__input" name="urn_search" id="urn_search" value="<?php echo $package->urn??'';?>" placeholder="Nombre del ataúd" autocomplete="off" />
            <div id="urns_dropdown" class="dropdown"></div>
        </div>
        <div id="urn_tags_div" class="form__list"></div>
        <input type="hidden" name="urn_id" value="<?php echo $package->urn_id??'';?>">
    </div>
    <div class="form__field">
        <label class="form__label" for="services_search">Servicio(s)</label>
        <div class="container_product">
            <input type="text" class="form__input" name="services_search" id="services_search" placeholder="Nombre del servicio" autocomplete="off">
            <div id="services_dropdown" class="dropdown"></div>
        </div>
        <div id="services_tags_div" class="form__list"></div>
        <input type="hidden" name="services_tags" value="<?php echo $package->services??'';?>">
        <input type="hidden" name="services_tags_ids" value="<?php echo $package->services_ids??'';?>">
    </div>
    <div class="form__field">
        <label class="form__label" for="complements_search">Complemento(s)</label>
        <div class="container_product">
            <input type="text" class="form__input" name="complements_search" id="complements_search" placeholder="Nombre del complemento" autocomplete="off">
            <div id="complements_dropdown" class="dropdown"></div>
        </div>
        <div id="complements_tags_div" class="form__list"></div>
        <input type="hidden" name="complements_tags" value="<?php echo $package->complements??'';?>">
        <input type="hidden" name="complements_tags_ids" value="<?php echo $package->complements_ids??'';?>">
    </div>
    <div class="form__field">
        <label class="form__label" for="chapels_search">Capilla</label>
        <div class="container_product">
            <input type="text" class="form__input" name="chapels_search" id="chapels_search" placeholder="Nombre de la capilla" autocomplete="off">
            <div id="chapels_dropdown" class="dropdown"></div>
        </div>
        <div id="chapels_tags_div" class="form__list"></div>
        <input type="hidden" name="chapels_tags" value="<?php echo $package->chapel??'';?>">
        <input type="hidden" name="chapels_tags_ids" value="<?php echo $package->chapel_id??'';?>">
    </div>
    <div class="form__field">
        <label class="form__label" for="hearses_search">Carroza</label>
        <div class="container_product">
            <input type="text" class="form__input" name="hearses_search" id="hearses_search" placeholder="Nombre de la carroza" autocomplete="off">
            <div id="hearses_dropdown" class="dropdown"></div>
        </div>
        <div id="hearses_tags_div" class="form__list"></div>
        <input type="hidden" name="hearses_tags" value="<?php echo $package->hearse??'';?>">
        <input type="hidden" name="hearses_tags_ids" value="<?php echo $package->hearse_id??'';?>">
    </div>
    <div class="form__field">
        <label class="form__label" for="cemeteries_search">Cementerio</label>
        <div class="container_product">
            <input type="text" class="form__input" name="cemeteries_search" id="cemeteries_search" placeholder="Nombre del cementerio" autocomplete="off">
            <div id="cemeteries_dropdown" class="dropdown"></div>
        </div>
        <div id="cemeteries_tags_div" class="form__list"></div>
        <input type="hidden" name="cemeteries_tags" value="<?php echo $package->cemetery??'';?>">
        <input type="hidden" name="cemeteries_tags_ids" value="<?php echo $package->cemetery_id??'';?>">
    </div>
    <div class="form__field">
        <label class="form__label" for="crematories_search">crematorio</label>
        <div class="container_product">
            <input type="text" class="form__input" name="crematories_search" id="crematories_search" placeholder="Nombre del crematorio" autocomplete="off">
            <div id="crematories_dropdown" class="dropdown"></div>
        </div>
        <div id="crematories_tags_div" class="form__list"></div>
        <input type="hidden" name="crematories_tags" value="<?php echo $package->crematory??'';?>">
        <input type="hidden" name="crematories_tags_ids" value="<?php echo $package->crematory_id??'';?>">
    </div>

</fieldset>

<fieldset class="form__fieldset">
    <legend for="package_tags" class="form__legend">Información adicional del paquete</legend>
    <div class="form__field">
        <label class="form__label" for="caracteristics">Características (separadas por coma)</label>
        <input type="text" class="form__input" id="package_tags" placeholder="Ejemplo: Ataúd, Caoba, Biodegradable">
        <div id="tags" class="form__list"></div>
        <input type="hidden" name="tags" value="<?php echo $package->tags??'';?>">
    </div>
</fieldset>