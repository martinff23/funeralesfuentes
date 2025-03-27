<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/hearses/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir carroza
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($hearses)){ ?>
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
                <?php foreach($hearses as $hearse){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $hearse->hearse_name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $hearse->hearse_description;?>
                        </td>
                        <td class="table__td">
                            <?php echo '$'.$hearse->hearse_cost.' MXN';?>
                        </td>
                        <td class="table__td">
                            <?php echo '$'.$hearse->hearse_price.' MXN';?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/hearses/edit?id=<?php echo $hearse->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/hearses/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $hearse->id; ?>">
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
        <p class="text-center">No hay carrozas registradas</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>