<?php

namespace App\Infrastructure\Http\Api\Controller;

use App\Application\DTO\TaskDTO;
use App\Domain\Entity\Task\Task;
use App\Application\Service\TaskService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractFOSRestController
{
    /**
     * @var TaskService
     */
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @Rest\Get("/tasks")
     * @return View
     */
    public function getTasksAction()
    {
        $tasks = $this->taskService->getAllTasks();

        return View::create($tasks, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/task/{id}")
     * @param Task $task
     * @return View
     */
    public function getTaskAction(Task $task)
    {
        return View::create($task, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/task")
     * @ParamConverter("taskDTO", converter="fos_rest.request_body")
     * @param Request $request
     * @return View
     */
    public function postTaskAction(TaskDTO $taskDTO)
    {
        $task = $this->taskService->addTask($taskDTO);

        return View::create($task, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put("/task/{id}")
     * @ParamConverter("taskDTO", converter="fos_rest.request_body")
     * @param Request $request
     * @param Task $task
     * @return View
     */
    public function putTaskAction(TaskDTO $taskDTO, Task $task)
    {
        $task = $this->taskService->updateTask($task, $taskDTO);

        return View::create($task, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/task/{id}")
     * @param Task $task
     * @return View
     */
    public function deleteTaskAction(Task $task)
    {
        $this->taskService->deleteTask($task);

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}