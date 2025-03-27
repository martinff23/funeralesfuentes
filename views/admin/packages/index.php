<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/packages/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir paquete
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($packages)){ ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Descripción</th>
                    <th scope="col" class="table__th">Costo</th>
                    <th scope="col" class="table__th">Precio</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($packages as $package){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $package->package_name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $package->package_description;?>
                        </td>
                        <td class="table__td">
                            <?php echo '$'.$package->package_cost.' MXN';?>
                        </td>
                        <td class="table__td">
                            <?php echo '$'.$package->package_price.' MXN';?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/packages/edit?id=<?php echo $package->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/packages/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $package->id; ?>">
                                <button class="table__action table__action--delete" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay paquetes registrados</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>