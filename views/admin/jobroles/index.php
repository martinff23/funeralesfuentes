<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/recordElements">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__button" href="/dashboard/jobroles/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir posición laboral
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($jobroles)){ ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Nombre visible</th>
                    <th scope="col" class="table__th">Banda mínima</th>
                    <th scope="col" class="table__th">Banda máxima</th>
                    <th scope="col" class="table__th">Estado</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($jobroles as $jobrole){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $jobrole->name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $jobrole->visual_name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $jobrole->min_salary;?>
                        </td>
                        <td class="table__td">
                            <?php echo $jobrole->max_salary;?>
                        </td>
                        <td class="table__td">
                            <?php echo $jobrole->status;?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/jobroles/edit?id=<?php echo $jobrole->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/jobroles/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $jobrole->id; ?>">
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
        <p class="text-center">No hay posiciones laborales registradas</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>