<?php

namespace Kosmos\Filter\ValueObject;

class DatePeriod
{
    public function __construct(
        protected readonly ?int $year = null,
        protected readonly ?int $quarter = null,
        protected readonly ?int $month = null
    ) {
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function getQuarter(): ?int
    {
        return $this->quarter;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function isEmpty(): bool
    {
        return $this->getYear() === null;
    }
}