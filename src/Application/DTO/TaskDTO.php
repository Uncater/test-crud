<?php


namespace App\Application\DTO;


class TaskDTO
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTimeInterface|null
     */
    private $dueDate;

    public function __construct(string $name, string $status, \DateTimeInterface $dueDate = null)
    {
        $this->name = $name;
        $this->status = $status;
        $this->dueDate = $dueDate;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }
}