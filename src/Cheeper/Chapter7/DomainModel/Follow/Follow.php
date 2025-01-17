<?php

declare(strict_types=1);

namespace Cheeper\Chapter7\DomainModel\Follow;

use Cheeper\AllChapters\DomainModel\Author\AuthorId;
use Cheeper\AllChapters\DomainModel\Follow\FollowId;
use Cheeper\Chapter7\DomainModel\TriggerEventsTrait;

// snippet follow-entity-with-events
final class Follow
{
    use TriggerEventsTrait;

    protected function __construct(
        private string $followId,
        private string $fromAuthorId,
        private string $toAuthorId,
    ) {
        $this->notifyDomainEvent(
            AuthorFollowed::fromFollow($this)
        );

        /**
         * As an alternative, we can use a Singleton
         * implementing an Observer pattern with
         * Subscribers that will publish the triggered
         * Domain Events into a queue system like
         * Rabbit. It's useful for Legacy projects
         * because you can trigger any Domain Event
         * from any place in your code, not only
         * Entities.
         *
         * DomainEventPublisher::getInstance()
         *     ->notifyDomainEvent(
         *         AuthorFollowed::fromFollow($this)
         *     )
         * );
         */
    }

    public static function fromAuthorToAuthor(
        FollowId $followId,
        AuthorId $fromAuthorId,
        AuthorId $toAuthorId,
    ): self {
        return new self(
            followId: $followId->toString(),
            fromAuthorId: $fromAuthorId->toString(),
            toAuthorId: $toAuthorId->toString()
        );
    }

    public function fromAuthorId(): AuthorId
    {
        return AuthorId::fromString($this->fromAuthorId);
    }

    public function toAuthorId(): AuthorId
    {
        return AuthorId::fromString($this->toAuthorId);
    }

    public function followId(): FollowId
    {
        return FollowId::fromString($this->followId);
    }
}
// end-snippet
