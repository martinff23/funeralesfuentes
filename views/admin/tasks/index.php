<h1 class="dashboard__heading"><?php echo $title;?></h1>

<div class="dashboard__button-container">
    <a class="dashboard__button" href="/dashboard/start">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<div class="dashboard__container">
    <?php if(!empty($tasks)){ ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Quién asignó</th>
                    <th scope="col" class="table__th">Estado</th>
                    <th scope="col" class="table__th">Prioridad</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($tasks as $task){ ?>
                    <tr class="table__tr task_row" data-id="<?php echo $task->id;?>">
                        <td class="table__td">
                            <?php echo $task->title;?>
                        </td>
                        <td class="table__td">
                            <?php echo $task->assigner_info->name." ".$task->assigner_info->f_name;?>
                        </td>
                        <td class="table__td table__td--<?php echo "" === getCellColorStatus($task->status) ? "none" : getCellColorStatus($task->status); ?>">
                            <?php echo strtoupper(getVisualValue($task->status));?>
                        </td>
                        <td class="table__td table__td--<?php echo "" === getCellColorPriority($task->priority) ? "none" : getCellColorPriority($task->priority); ?>">
                            <?php echo strtoupper(getVisualValue($task->priority));?>
                        </td>
                        <td class="table__td--actions-tasks">
                            <?php if("COMPLETED" !== strtoupper($task->status) && "RETURNED" !== strtoupper($task->status)){ ?>
                                <a class="table__action table__action--complete button_complete_task" data-id="<?php echo $task->id;?>" data-underlyingid="0">
                                    <i class="fa-solid fa-user-check"></i>
                                    Completar
                                </a>
                                <?php if("CONTACT" === strtoupper($task->task_type)){ ?>
                                    <a class="table__action table__action--return button_return_contact" data-id="<?php echo $task->id;?>" data-underlyingid="<?php echo $task->underlyingId;?>">
                                        <i class="fa-solid fa-rotate-left"></i>
                                        Devolver
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay tareas registradas</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>