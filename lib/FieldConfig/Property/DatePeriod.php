<?php

namespace Kosmos\Filter\FieldConfig\Property;

class DatePeriod implements PropertyInterface
{
    public function __construct(
        protected readonly string $year = 'YEAR',
        protected readonly string $quarter = 'QUARTER',
        protected readonly string $month = 'MONTH'
    ) {
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function getQuarter(): string
    {
        return $this->quarter;
    }

    public function getMonth(): string
    {
        return $this->month;
    }
}