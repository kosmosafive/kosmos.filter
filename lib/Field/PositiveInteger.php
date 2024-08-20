<?php

namespace Kosmos\Filter\Field;

use Kosmos\Filter\FieldConfig\FieldConfigInterface;

class PositiveInteger extends Integer
{
    public function __construct(
        FieldConfigInterface $fieldConfig
    ) {
        parent::__construct($fieldConfig, 1);
    }
}