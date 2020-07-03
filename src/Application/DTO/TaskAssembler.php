<?php


namespace App\Application\DTO;

use App\Domain\Entity\Task\Task;

class TaskAssembler
{
    /**
     * @param TaskDTO $taskDTO
     * @param Task|null $task
     * @return Task
     */
    public function readDTO(TaskDTO $taskDTO, ?Task $task = null): Task
    {
        if (!$task) {
            $task = new Task();
        }

        $task->setName($taskDTO->getName());
        $task->setStatus($taskDTO->getStatus());
        $task->setDueDate($taskDTO->getDueDate());

        return $task;
    }

    /**
     * @param Task $task
     * @param TaskDTO $taskDTO
     * @return Task
     */
    public function updateTask(Task $task, TaskDTO $taskDTO): Task
    {
        return $this->readDTO($taskDTO, $task);
    }

    /**
     * @param TaskDTO $taskDTO
     * @return Task
     */
    public function createTask(TaskDTO $taskDTO): Task
    {
        return $this->readDTO($taskDTO);
    }

    /**
     * @param Task $task
     * @return TaskDTO
     */
    public function writeDTO(Task $task)
    {
        return new TaskDTO(
            $task->getName(),
            $task->getStatus(),
            $task->getDueDate()
        );
    }
}