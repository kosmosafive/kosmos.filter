<?php

namespace Kosmos\Filter\FieldConfig\Property;

use Kosmos\Filter\Structure\Collection;

class PropertyCollection extends Collection
{
    public function __construct(PropertyInterface ...$properties)
    {
        parent::__construct();

        $this->values = $properties;
    }
}