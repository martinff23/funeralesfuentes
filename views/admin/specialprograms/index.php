<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/alliMenu">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__button" href="/dashboard/specialprograms/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir programa
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($specialprograms)){ ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Nombre visible</th>
                    <th scope="col" class="table__th">Fuente</th>
                    <th scope="col" class="table__th">Estado</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($specialprograms as $specialprogram){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $specialprogram->name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $specialprogram->visual_name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $specialprogram->source;?>
                        </td>
                        <td class="table__td">
                            <?php echo $specialprogram->status;?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/specialprograms/edit?id=<?php echo $specialprogram->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/specialprograms/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $specialprogram->id; ?>">
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
        <p class="text-center">No hay programas registrados</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>