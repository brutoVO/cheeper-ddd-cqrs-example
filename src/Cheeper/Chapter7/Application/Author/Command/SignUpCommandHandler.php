<?php

declare(strict_types=1);

namespace Cheeper\Chapter7\Application\Author\Command;

use Cheeper\AllChapters\DomainModel\Author\AuthorAlreadyExists;
use Cheeper\AllChapters\DomainModel\Author\AuthorId;
use Cheeper\AllChapters\DomainModel\Author\BirthDate;
use Cheeper\AllChapters\DomainModel\Author\EmailAddress;
use Cheeper\AllChapters\DomainModel\Author\UserName;
use Cheeper\AllChapters\DomainModel\Author\Website;
use Cheeper\Chapter7\Application\EventBus;
use Cheeper\Chapter7\DomainModel\Author\Author;
use Cheeper\Chapter7\DomainModel\Author\AuthorRepository;

//snippet sign-up-handler-with-events
final class SignUpCommandHandler
{
    public function __construct(
        private readonly AuthorRepository $authors,
        private readonly EventBus         $eventBus
    ) {
    }

    public function __invoke(SignUpCommand $command): void
    {
        $userName = UserName::pick($command->userName());
        $authorId = AuthorId::fromString($command->authorId());
        $email = EmailAddress::from($command->email());

        $author = $this->authors->ofUserName($userName);
        $this->checkAuthorDoesNotAlreadyExistByUsername($author, $userName);

        $author = $this->authors->ofId($authorId);
        $this->checkAuthorDoesNotAlreadyExistById($author, $authorId);

        $website = $this->getWebsite($command);
        $birthDate = $this->getBirthDate($command);

        $author = $this->signUpAuthor($authorId, $userName, $email, $command, $website, $birthDate);

        $this->storeAuthor($author);
        $this->notifyDomainEvents($author, $command);
    }

    private function checkAuthorDoesNotAlreadyExistByUsername(?Author $author, UserName $userName): void
    {
        if (null !== $author) {
            throw AuthorAlreadyExists::withUserNameOf($userName);
        }
    }

    private function checkAuthorDoesNotAlreadyExistById(?Author $author, AuthorId $authorId): void
    {
        if (null !== $author) {
            throw AuthorAlreadyExists::withIdOf($authorId);
        }
    }

    private function getBirthDate(SignUpCommand $command): ?BirthDate
    {
        $inputBirthDate = $command->birthDate();

        return null !== $inputBirthDate ? BirthDate::fromString($inputBirthDate) : null;
    }

    private function getWebsite(SignUpCommand $command): ?Website
    {
        $inputWebsite = $command->website();

        return null !== $inputWebsite ? Website::fromString($inputWebsite) : null;
    }

    private function signUpAuthor(
        AuthorId $authorId,
        UserName $userName,
        EmailAddress $email,
        SignUpCommand $command,
        ?Website $website,
        ?BirthDate $birthDate)
    : Author {
        return Author::signUp(
            $authorId,
            $userName,
            $email,
            $command->name(),
            $command->biography(),
            $command->location(),
            $website,
            $birthDate
        );
    }

    private function notifyDomainEvents(Author $author, SignUpCommand $command): void
    {
        $domainEvents = $author->domainEvents();
        foreach ($domainEvents as $domainEvent) {
            $domainEvent->stampAsResponseTo($command);
        }

        $this->eventBus->notifyAll($domainEvents);
    }

    private function storeAuthor(Author $author): void
    {
        $this->authors->add($author);
    }
}
//end-snippet
