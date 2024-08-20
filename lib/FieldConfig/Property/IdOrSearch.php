<?php

namespace Kosmos\Filter\FieldConfig\Property;

class IdOrSearch implements PropertyInterface
{
    public function __construct(
        protected readonly string $idName,
        protected readonly PropertyCollection $propertyCollection
    ) {
    }

    public function getPropertyCollection(): PropertyCollection
    {
        return $this->propertyCollection;
    }

    public function getIdName(): string
    {
        return $this->idName;
    }
}