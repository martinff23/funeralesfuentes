<?php 

namespace Controllers;

use Model\Contact;
use Model\Task;
use Model\User;

class APITaskController {

    /**
     * Toma una tarea desde un contacto y asigna a un usuario.
     * 
     * Espera una solicitud POST con un JSON que contenga:
     * - contactId: int
     * - taskType: string
     * - userId: int
     * - assignerId: int
     * 
     * Devuelve una respuesta JSON con estructura estándar:
     * {
     *   "success": bool,
     *   "message": string,
     *   "data": mixed|null
     * }
     * 
     * @return void
     */
    public static function takeContact(): void {

        // Validar método
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
            exit;
        }

        /** @var array<string, mixed> $input */
        $input = json_decode(file_get_contents('php://input'), true);

        if (
            empty($input['contactId']) ||
            empty($input['taskType']) ||
            empty($input['userId']) ||
            empty($input['assignerId'])
        ) {
            http_response_code(400); // Bad Request
            echo json_encode([
                'success' => false,
                'message' => 'Todos los campos son obligatorios'
            ]);
            exit;
        }

        /** @var Task $task */
        $task = new Task();

        /** @var Contact|null $contact */
        $contact = Contact::find($input['contactId']);

        if (!$contact) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'No se encontró el contacto relacionado'
            ]);
            exit;
        }

        $_POST = [
            'underlyingId' => $input['contactId'],
            'task_type' => $input['taskType'],
            'userId' => $input['userId'],
            'assigner' => $input['assignerId'],
            'status' => 'ACTIVE',
            'entered_date' => date('Y-m-d'),
            'closed_date' => '9999-12-31',
            'name' => $contact->name,
            'telephone' => $contact->telephone,
            'email' => $contact->email
        ];

        $_POST['title'] = "Contactar a ".$_POST['name'];
        $_POST['notes'] = "Contactar urgentemente a " . $_POST['name'] . " para brindarle información sobre Funerales Fuentes. Háblale sobre nuestra misión, visión, valores, creencias. Mencionales nuestra propuesta de valor, platícale de nuestros casos de éxito y mencionale nuestros planes de pago. Su teléfono es " . $_POST['telephone'] . " y su correo electrónico es " . $_POST['email'] . ". Al terminar el contacto, no olvides registrarlo en el sistema. Recuerda que cumplir o no cumplir con tus tareas tiene impacto en tu evaluación.";

        $task->sincronize($_POST);
        // error_log($_POST);

        /** @var array<int, string> $alerts */
        $alerts = $task->validate();

        if (!empty($alerts)) {
            http_response_code(422); // Unprocessable Entity
            echo json_encode([
                'success' => false,
                'message' => 'Error de validación',
                'data' => ['alerts' => $alerts]
            ]);
            exit;
        }

        /** @var bool $result */
        $result = $task->saveElement();

        if (!$result) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al guardar la tarea'
            ]);
            exit;
        }

        $contact->status = 'TAKEN';
        $contact->assignee = $_POST['userId'];
        $resultContact = $contact->saveElement();

        if (!$resultContact) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar el estado del contacto, contactar al administrador'
            ]);
            exit;
        }

        // 🎉 Éxito total
        echo json_encode([
            'success' => true,
            'message' => 'Tarea tomada correctamente y contacto actualizado',
            'data' => [
                'underlyingId' => $task->id ?? null,
                'contactId' => $contact->id ?? null
            ]
        ]);
    }

    public static function getTask(): void {

        /** @var array<string, mixed> $input */
        $input = json_decode(file_get_contents('php://input'), true);

        if (empty($input['id'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'El ID es obligatorio'
            ]);
            exit;
        }

        $task = Task::find($input['id']);
        $assigner = User::find($task->assigner);

        $data = [
            'id' => $task->id,
            'title' => $task->title,
            'notes' => $task->notes,
            'requirement' => $task->requirement,
            'assigner' => $assigner->name . " " . $assigner->f_name,
            'status' => strtoupper(getVisualValue($task->status))
        ];

        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Marca una tarea como completada y actualiza el estado del contacto asociado.
     * Endpoint: POST /api/completetask
     *
     * @return void
     */
    public static function completeTask(): void{
        header('Content-Type: application/json; charset=utf-8');

        /** @var array<string, mixed> $input */
        $input = json_decode(file_get_contents('php://input'), true);

        $taskId = isset($input['id']) ? (int)$input['id'] : 0;
        $underlyingId = isset($input['underlyingId']) ? (int)$input['underlyingId'] : 0;

        if ($taskId === 0 || $underlyingId < 0) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Todos los datos son obligatorios'
            ]);
            exit;
        }

        $task = Task::find($taskId);

        if (!$task) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener la tarea'
            ]);
            exit;
        }

        $task->status = "COMPLETED";
        $task->priority = "NONE";

        if ($underlyingId !== 0) {
            $contact = Contact::find($underlyingId);

            if (!$contact) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al obtener el contacto'
                ]);
                exit;
            }

            $contact->status = 'COMPLETED';

            $resultTask = $task->saveElement();
            $resultContact = $contact->saveElement();

            if ($resultTask && $resultContact) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Tarea y contacto guardados correctamente'
                ]);
            } else if ($resultTask && !$resultContact) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Tarea guardada, pero error al guardar el contacto'
                ]);
            } else if (!$resultTask && $resultContact) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Contacto guardado, pero error al guardar la tarea'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al guardar la tarea y el contacto'
                ]);
            }
        } else {
            $result = $task->saveElement();
            if (!$result) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al guardar la tarea'
                ]);
            } else {
                echo json_encode([
                    'success' => true, // ✅ corregido
                    'message' => 'Tarea guardada con éxito'
                ]);
            }
        }
    }

    /**
     * Marks a task as "RETURNED", appends a return comment to the notes,
     * and optionally updates the related contact status to "ACTIVE".
     *
     * This method expects a JSON payload via POST containing:
     * - id (int): Task ID
     * - underlyingId (int): Related contact ID (0 if not applicable)
     * - comment (string): Reason for returning the task
     *
     * @return void
     */
    public static function returnTask(): void{
        header('Content-Type: application/json; charset=utf-8');

        /** @var array<string, mixed> $input */
        $input = json_decode(file_get_contents('php://input'), true);

        $taskId = isset($input['id']) ? (int)$input['id'] : 0;
        $underlyingId = isset($input['underlyingId']) ? (int)$input['underlyingId'] : 0;
        $comment = isset($input['comment']) ? trim($input['comment']) : '';

        if ($taskId === 0 || $underlyingId < 0 || $comment === '') {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Task ID, underlying contact ID, and comment are required.'
            ]);
            exit;
        }

        $task = Task::find($taskId);

        if (!$task) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Task not found.'
            ]);
            exit;
        }

        $task->status = "RETURNED";
        $task->priority = "NONE";
        $task->notes = trim($task->notes . "\nMotivo de retorno: " . $comment);

        if ($underlyingId !== 0) {
            $contact = Contact::find($underlyingId);

            if (!$contact) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Contact not found.'
                ]);
                exit;
            }

            // Optionally reset contact status based on deadline logic
            $contact->status = 'ACTIVE';

            $resultTask = $task->saveElement();
            $resultContact = $contact->saveElement();

            if ($resultTask && $resultContact) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Task and contact updated successfully.'
                ]);
            } elseif ($resultTask && !$resultContact) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Task updated but failed to update contact.'
                ]);
            } elseif (!$resultTask && $resultContact) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Contact updated but failed to update task.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update both task and contact.'
                ]);
            }
        } else {
            $result = $task->saveElement();
            if (!$result) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update task.'
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'message' => 'Task updated successfully.'
                ]);
            }
        }
    }
}