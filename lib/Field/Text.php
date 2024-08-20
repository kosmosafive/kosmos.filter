<?php

namespace Kosmos\Filter\Field;

use Kosmos\Filter\ValueObject\FormData;

class Text extends Base
{
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

    protected function filterValue(mixed $value): ?string
    {
        return $this->filterString($value);
    }
}