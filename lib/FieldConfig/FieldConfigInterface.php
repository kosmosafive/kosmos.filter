<?php

namespace Kosmos\Filter\FieldConfig;

interface FieldConfigInterface
{
    public function getProperty(): Property\PropertyInterface;

    public function getId(): string;
}