<?php

namespace Kosmos\Filter\FieldConfig;

abstract class Base implements FieldConfigInterface
{

    public function __construct(
        protected readonly Property\PropertyInterface $property,
        protected readonly string $id
    ) {
    }

    public function getProperty(): Property\PropertyInterface
    {
        return $this->property;
    }

    public function getId(): string
    {
        return $this->id;
    }
}