<?php

namespace Kosmos\Filter\FieldConfig;

class IdOrSearch extends Base
{
    public function __construct(
        Property\IdOrSearch $property,
        string $id
    ) {
        parent::__construct($property, $id);
    }
}