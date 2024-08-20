<?php

namespace Kosmos\Filter\QueryBuilder;

use Kosmos\Filter\Field\FieldCollection;
use Kosmos\Filter\Handler\Factory;
use Kosmos\Filter\ValueObject\FormData;

abstract class Base implements QueryBuilderInterface
{

    public function apply(
        FieldCollection $fieldCollection,
        FormData $formData
    ): void {
        foreach ($fieldCollection as $field) {
            $handler = Factory::create(static::TYPE, $field);
            $handler->apply($this, $field, $formData);
        }
    }
}