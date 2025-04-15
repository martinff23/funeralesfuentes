<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/alliMenu">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__button" href="/dashboard/alliances/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir alianza
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($alliances)){ ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Estado</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($alliances as $alliance){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $alliance->business_name;?>
                        </td>
                        <td class="table__td">
                            <?php echo empty($alliance->status) ? 'none' : ('ACTIVE' === strtoupper($alliance->status) ? 'Activa' : 'Inactiva');?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/alliances/edit?id=<?php echo $alliance->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/alliances/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $alliance->id; ?>">
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
        <p class="text-center">No hay alianzas registradas</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>