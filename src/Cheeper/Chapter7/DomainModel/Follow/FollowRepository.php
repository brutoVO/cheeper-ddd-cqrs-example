<?php

declare(strict_types=1);

namespace Cheeper\Chapter7\DomainModel\Follow;

use Cheeper\AllChapters\DomainModel\Author\AuthorId;

//snippet follows
interface FollowRepository
{
    public function numberOfFollowersFor(AuthorId $authorId): int;
    public function add(Follow $follow): void;
    public function fromAuthorIdAndToAuthorId(AuthorId $fromAuthorId, AuthorId $toAuthorId): ?Follow;
    /** @return Follow[] */
    public function toAuthorId(AuthorId $authorId): array;
}
//end-snippet
