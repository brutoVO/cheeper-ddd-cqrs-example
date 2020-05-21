<?php

declare(strict_types=1);

namespace Cheeper\Application\Command\Author;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

//snippet sign-up
final class SignUp
{
    private UuidInterface $authorId;
    private string $userName;
    private string $name;
    private string $biography;
    private string $location;
    private string $website;
    private DateTimeImmutable $birthDate;

    public function __construct(
        UuidInterface $authorId,
        string $userName,
        string $name,
        string $biography,
        string $location,
        string $website,
        DateTimeImmutable $birthDate
    ) {
        $this->authorId = $authorId;
        $this->userName = $userName;
        $this->name = $name;
        $this->biography = $biography;
        $this->location = $location;
        $this->website = $website;
        $this->birthDate = $birthDate;
    }

    public function getAuthorId(): UuidInterface
    {
        return $this->authorId;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getBiography(): string
    {
        return $this->biography;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getBirthDate(): DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setAuthorId(UuidInterface $authorId): void
    {
        $this->authorId = $authorId;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setBiography(string $biography): void
    {
        $this->biography = $biography;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function setWebsite(string $website): void
    {
        $this->website = $website;
    }

    public function setBirthDate(DateTimeImmutable $birthDate): void
    {
        $this->birthDate = $birthDate;
    }
}
//end-snippet
