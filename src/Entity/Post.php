<?php

declare(strict_types=1);

namespace Super\Entity;

class Post
{
    private string $id;
    private string $userName;
    private string $userId;
    private string $message;
    private string $type;
    private \DateTimeInterface $createdAt;

    public function __construct(string $id, string $userName, string $userId, string $message, string $type, \DateTimeInterface $createdAt)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->userId = $userId;
        $this->message = $message;
        $this->type = $type;
        $this->createdAt = $createdAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
