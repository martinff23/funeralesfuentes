<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/users">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__button" href="/dashboard/users/others/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir usuario
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($users)){ ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Correo</th>
                    <th scope="col" class="table__th">Teléfono</th>
                    <th scope="col" class="table__th">Rol</th>
                    <th scope="col" class="table__th">Estado</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($users as $us){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $us->name.' '.$us->f_name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $us->email;?>
                        </td>
                        <td class="table__td">
                            <?php echo $us->telephone;?>
                        </td>
                        <td class="table__td">
                            <?php echo getVisualValue(getUserRole());?>
                        </td>
                        <td class="table__td">
                            <?php echo getVisualValue($us->status);?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/users/others/edit?id=<?php echo $us->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/users/others/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $us->id; ?>">
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
        <p class="text-center">No hay usuarios registrados</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>