<?php


namespace App\Application\Service;


use App\Application\DTO\TaskAssembler;
use App\Application\DTO\TaskDTO;
use App\Domain\Entity\Task\Task;
use App\Domain\Entity\Task\TaskRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;

class TaskService
{
    /**
     * @var TaskRepositoryInterface
     */
    private $taskRepository;

    /**
     * @var TaskAssembler
     */
    private $taskAssembler;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        TaskAssembler $taskAssembler
    ) {
        $this->taskRepository = $taskRepository;
        $this->taskAssembler = $taskAssembler;
    }

    /**
     * @param int $id
     * @return Task
     * @throws EntityNotFoundException
     */
    public function getTask(int $id): Task
    {
        $task = $this->taskRepository->find($id);
        if (!$task) {
            throw new EntityNotFoundException("Task $id doesn't exist");
        }

        return $task;
    }

    /**
     * @return array|null
     */
    public function getAllTasks(): ?array
    {
        return $this->taskRepository->findAll();
    }

    /**
     * @param TaskDTO $taskDTO
     * @return Task
     */
    public function addTask(TaskDTO $taskDTO): Task
    {
        $task = $this->taskAssembler->createTask($taskDTO);
        $this->taskRepository->save($task);

        return $task;
    }

    /**
     * @param Task $task
     * @param TaskDTO $taskDTO
     * @return Task
     */
    public function updateTask(Task $task, TaskDTO $taskDTO): Task
    {
        $task = $this->taskAssembler->updateTask($task, $taskDTO);
        $this->taskRepository->save($task);

        return $task;
    }

    /**
     * @param Task $task
     */
    public function deleteTask(Task $task): void
    {
        $this->taskRepository->delete($task);
    }
}