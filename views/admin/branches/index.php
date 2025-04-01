<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/branches/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir sucursal
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($branches)){ ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">ISO</th>
                    <th scope="col" class="table__th">Dirección</th>
                    <th scope="col" class="table__th">Teléfono</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($branches as $branch){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $branch->branch_name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $branch->branch_ISO;?>
                        </td>
                        <td class="table__td">
                            <?php echo $branch->address;?>
                        </td>
                        <td class="table__td">
                            <?php echo $branch->telephone;?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/branches/edit?id=<?php echo $branch->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/branches/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $branch->id; ?>">
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
        <p class="text-center">No hay sucursales registradas</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>