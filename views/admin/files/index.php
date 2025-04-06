<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/files/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir archivo
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($files)){ ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Ruta</th>
                    <th scope="col" class="table__th">Nombre real</th>
                    <th scope="col" class="table__th">Nombre servidor</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($files as $file){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo '/public/build/img/'.$file->route.'/';?>
                        </td>
                        <td class="table__td">
                            <?php echo $file->real_name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $file->image;?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/files/edit?id=<?php echo $file->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/files/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $file->id; ?>">
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
        <p class="text-center">No hay archivos registrados</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>