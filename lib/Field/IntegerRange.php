<?php

namespace Kosmos\Filter\Field;

use Kosmos\Filter\FieldConfig;
use Kosmos\Filter\ValueObject;

class IntegerRange extends Base
{
    public function __construct(
        FieldConfig\Range $fieldConfig,
        protected readonly ?int $min = null,
        protected readonly ?int $max = null
    ) {
        parent::__construct($fieldConfig);

        $this->value = new ValueObject\Range();
    }

    public function setFormValue(ValueObject\FormData $formData): void
    {
        $formValue = [];

        foreach (['from', 'to'] as $key) {
            $value = $formData->offsetGet($this->fieldConfig->getId() . '_' . $key);
            $filteredValue = $this->filterInteger($value, $this->min, $this->max);

            $formValue[$key] = $filteredValue;
        }

        $this->value = new ValueObject\Range(...$formValue);
    }

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }
}