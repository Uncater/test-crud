<?php


namespace App\Domain\Entity\Task;

interface TaskRepositoryInterface
{
    public function find(int $id) :?Task;
    public function findAll() :array;
    public function save(Task $task) :void;
    public function delete(Task $task) :void;
}