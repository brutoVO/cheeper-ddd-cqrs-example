<?php

namespace CheeperLayered;

//snippet cheep
class Cheep
{
    private ?int $id = null;
    private int $authorId;
    private string $message;

    public static function compose(int $authorId, string $message): self
    {
        return new static($authorId, $message);
    }

    private function __construct(int $authorId, string $message)
    {
        $this->authorId = $authorId;
        $this->setMessage($message);
    }

    private function setMessage(string $message): void
    {
        if (empty($message)) {
            throw new \RuntimeException('Message cannot be empty');
        }

        $this->message = $message;
    }

    public function authorId(): int
    {
        return $this->authorId;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function id(): ?int
    {
        return $this->id;
    }
}
//end-snippet
