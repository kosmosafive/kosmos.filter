<?php

namespace Kosmos\Filter\FieldConfig\Property;

class Single implements PropertyInterface
{
    public function __construct(
        protected readonly string $name
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}