<?php

namespace Kosmos\Filter\Field;

use Kosmos\Filter\Structure\Collection;
use Kosmos\Filter\ValueObject\FormData;

class FieldCollection extends Collection
{
    public function add(FieldInterface $field): FieldCollection
    {
        $this->values[$field->getFieldConfig()->getId()] = $field;

        return $this;
    }

    public function get(string $propertyName): ?FieldInterface
    {
        return $this->values[$propertyName] ?? null;
    }

    public function setFormData(FormData $formData): void
    {
        foreach ($this->values as $field) {
            $field->setFormValue($formData);
        }
    }
}