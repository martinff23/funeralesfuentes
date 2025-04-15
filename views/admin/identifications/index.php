<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/recordElements">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__button" href="/dashboard/identifications/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir identificación
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($identifications)){ ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Nombre visible</th>
                    <th scope="col" class="table__th">País</th>
                    <th scope="col" class="table__th">Estado</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($identifications as $identification){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $identification->name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $identification->visual_name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $identification->country;?>
                        </td>
                        <td class="table__td">
                            <?php echo $identification->status;?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/identifications/edit?id=<?php echo $identification->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/identifications/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $identification->id; ?>">
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
        <p class="text-center">No hay identificaciones registradas</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>