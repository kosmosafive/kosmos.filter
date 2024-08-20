<?php

namespace Kosmos\Filter\FieldConfig\Property;

class Multiple implements PropertyInterface
{
    public function __construct(
        protected readonly PropertyCollection $propertyCollection,
    ) {
    }

    public function getPropertyCollection(): PropertyCollection
    {
        return $this->propertyCollection;
    }
}