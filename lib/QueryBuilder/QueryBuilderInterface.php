<?php

namespace Kosmos\Filter\QueryBuilder;

use Kosmos\Filter\Field\FieldCollection;
use Kosmos\Filter\ValueObject\FormData;

interface QueryBuilderInterface
{
    public function apply(
        FieldCollection $fieldCollection,
        FormData $formData
    ): void;
}