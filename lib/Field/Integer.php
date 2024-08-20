<?php

namespace Kosmos\Filter\Field;

use Kosmos\Filter\FieldConfig\FieldConfigInterface;
use Kosmos\Filter\ValueObject\FormData;

class Integer extends Base
{
    public function __construct(
        FieldConfigInterface $fieldConfig,
        protected readonly ?int $min = null,
        protected readonly ?int $max = null
    ) {
        parent::__construct($fieldConfig);
    }

    public function setFormValue(FormData $formData): void
    {
        $formValue = $formData->offsetGet($this->fieldConfig->getId());
        if (!$formValue) {
            return;
        }

        if (
            is_string($formValue)
            && str_contains($formValue, ',')
        ) {
            $formValue = explode(',', $formValue);
        }

        if (is_array($formValue)) {
            $arFormValue = array_filter(
                array_map(fn($value) => $this->filterValue($value), $formValue),
                static fn($value) => !empty($value)
            );

            $this->value = (empty($arFormValue)) ? null : $arFormValue;
        } else {
            $this->value = $this->filterValue($formValue);
        }
    }

    protected function filterValue(mixed $value): ?int
    {
        return $this->filterInteger($value, $this->min, $this->max);
    }
}