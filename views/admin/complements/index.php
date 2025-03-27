<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/complements/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir extra
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($complements)){ ?>
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
                <?php foreach($complements as $complement){ ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $complement->complement_name;?>
                        </td>
                        <td class="table__td">
                            <?php echo $complement->complement_description;?>
                        </td>
                        <td class="table__td">
                            <?php echo '$'.$complement->complement_cost.' MXN';?>
                        </td>
                        <td class="table__td">
                            <?php echo '$'.$complement->complement_price.' MXN';?>
                        </td>
                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/dashboard/complements/edit?id=<?php echo $complement->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/dashboard/complements/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $complement->id; ?>">
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
        <p class="text-center">No hay extras registrados</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>