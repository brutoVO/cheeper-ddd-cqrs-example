<?php

declare(strict_types=1);

namespace Cheeper\Chapter7\DomainModel\Follow;

use Cheeper\AllChapters\DomainModel\Author\AuthorId;

//snippet follows
interface Follows
{
    public function numberOfFollowersFor(AuthorId $authorId): int;
    public function add(Follow $follow): void;
    public function ofFromAuthorIdAndToAuthorId(AuthorId $fromAuthorId, AuthorId $toAuthorId): ?Follow;
    /** @return Follow[] */
    public function toAuthorId(AuthorId $authorId): array;
}
//end-snippet