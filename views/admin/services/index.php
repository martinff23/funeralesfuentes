<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/workElements">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__button" href="/dashboard/services/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir servicio
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($services)){ ?>
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
                <?php foreach($services as $service){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $service->service_name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $service->service_description;?>
                        </td>
                        <td class="table__td">
                            <?php echo '$'.$service->service_cost.' MXN';?>
                        </td>
                        <td class="table__td">
                            <?php echo '$'.$service->service_price.' MXN';?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/services/edit?id=<?php echo $service->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/services/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $service->id; ?>">
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
        <p class="text-center">No hay servicios registrados</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>