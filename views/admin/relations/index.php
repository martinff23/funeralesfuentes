<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/recordElements">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__button" href="/dashboard/relations/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir relación de contacto
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($relations)){ ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Nombre visual</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($relations as $relation){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $relation->name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $relation->visual_name;?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/relations/edit?id=<?php echo $relation->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/relations/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $relation->id; ?>">
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
        <p class="text-center">No hay relaciones de contacto registradas</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>