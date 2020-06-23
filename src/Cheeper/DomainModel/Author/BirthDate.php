<?php

declare(strict_types=1);

namespace Cheeper\DomainModel\Author;

use Cheeper\DomainModel\Common\ValueObject;
use DateTimeInterface;
use Safe\DateTimeImmutable;
use Safe\Exceptions\DatetimeException;

final class BirthDate extends ValueObject
{
    private DateTimeInterface $date;

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
            throw new \InvalidArgumentException("'$date' is not a valid datetime (Y-m-d formatted).", 0, $exception);
        }
    }
}
