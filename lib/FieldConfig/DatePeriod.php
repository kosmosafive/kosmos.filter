<?php

namespace Kosmos\Filter\FieldConfig;

class DatePeriod extends Base
{
    public function __construct(
        Property\DatePeriod $property,
        string $id
    ) {
        parent::__construct($property, $id);
    }
}