<?php

declare(strict_types=1);

namespace Cheeper\DomainModel\Cheep;

use Cheeper\DomainModel\Common\ValueObject;
use InvalidArgumentException;
use Safe\DateTimeImmutable;
use Safe\Exceptions\DatetimeException;

final class CheepDate extends ValueObject
{
    private DateTimeImmutable $date;

    public function __construct(string $date)
    {
        $this->setDate($date);
    }

    public function date(): string
    {
        return $this->date->format('Y-m-d');
    }

    private function setDate(string $date): void
    {
        try {
            $this->date = DateTimeImmutable::createFromFormat('Y-m-d', $date);
        } catch (DatetimeException $exception) {
            throw new InvalidArgumentException("'$date' is not a valid datetime (Y-m-d formatted).");
        }
    }
}
