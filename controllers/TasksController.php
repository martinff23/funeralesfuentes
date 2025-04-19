<?php

namespace Controllers;

use Model\Contact;
use Model\Task;
use Model\User;
use MVC\Router;


class TasksController {
    public static function dashboard(Router $router){
        session_start();

        if(isset($_SESSION['id'])){
            $user =  User::find($_SESSION['id']);
            $countcontacts = Contact::countRecords('status', 'ACTIVE');
            $counttasks = Task::countRecords('status', 'ACTIVE');

            $tasks = [];
            // $tasksPre = Task::allWhereNot('status', 'COMPLETED');
            $tasksPre = Task::all();

            foreach($tasksPre as $task){
                if($task->userId === $_SESSION['id']){
                    $task->assigner_info = User::find($task->assigner);
                    array_push($tasks, $task);
                }
            }

            $router->render('admin/tasks/index',[
                'title' => 'Tareas del colaborador',
                'user' => $user,
                'countcontacts' => $countcontacts,
                'counttasks' => $counttasks,
                'tasks' => $tasks
            ]);
        
        } else{
            header('Location: /404');
        }
    }
}