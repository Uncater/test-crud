<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Task\Task;
use App\Domain\Entity\Task\TaskRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $objectRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(Task::class);
    }

    public function find(int $id): ?Task
    {
        return $this->objectRepository->find($id);
    }

    public function findAll(): array
    {
        return $this->objectRepository->findAll();
    }

    public function save(Task $task): void
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function delete(Task $task): void
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }
}
