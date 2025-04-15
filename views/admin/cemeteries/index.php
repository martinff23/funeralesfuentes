<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/workElements">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__button" href="/dashboard/cemeteries/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir cementerio
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($cemeteries)){ ?>
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
                <?php foreach($cemeteries as $cemetery){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $cemetery->cemetery_name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $cemetery->cemetery_description;?>
                        </td>
                        <td class="table__td">
                            <?php echo '$'.$cemetery->cemetery_cost.' MXN';?>
                        </td>
                        <td class="table__td">
                            <?php echo '$'.$cemetery->cemetery_price.' MXN';?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/cemeteries/edit?id=<?php echo $cemetery->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/cemeteries/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $cemetery->id; ?>">
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
        <p class="text-center">No hay cementerios registrados</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>