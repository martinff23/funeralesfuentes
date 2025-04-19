<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/start">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($contacts)){ ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Teléfono</th>
                    <th scope="col" class="table__th">Correo electrónico</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($contacts as $contact){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $contact->name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $contact->telephone;?>
                        </td>
                        <td class="table__td">
                            <?php echo $contact->email;?>
                        </td>
                        <td class="table__td--actions-contacts">
                            <a class="table__action table__action--take button_take_contact" data-contactid="<?php echo $contact->id;?>" data-tasktype="CONTACT" data-userid="<?php echo $_SESSION['id'];?>" data-assignerid="<?php echo $_SESSION['id'];?>">
                                <i class="fa-solid fa-hand-point-up"></i>
                                Tomar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay solicitudes de contacto registradas</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>