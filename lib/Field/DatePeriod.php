<?php

namespace Kosmos\Filter\Field;

use Kosmos\Filter\FieldConfig;
use Kosmos\Filter\ValueObject;

class DatePeriod extends Base
{
    protected readonly int $minYear;
    protected readonly int $maxYear;

    public function __construct(
        FieldConfig\DatePeriod $fieldConfig,
        int $minYear = null,
        int $maxYear = null
    ) {
        $this->maxYear = $maxYear ?: date('Y');
        $this->minYear = $minYear ?: ($this->maxYear - 10);

        parent::__construct($fieldConfig);
    }

    public function setFormValue(ValueObject\FormData $formData): void
    {
        $this->value = new ValueObject\DatePeriod();

        $selectorData = [];
        foreach (['year', 'quarter', 'month'] as $key) {
            $formValue = $formData->offsetGet($this->fieldConfig->getId() . '_' . $key);

            switch ($key) {
                case 'quarter':
                    $value = $this->filterInteger($formValue, 1, 4);
                    break;
                case 'month':
                    $value = $this->filterInteger($formValue, 1, 12);
                    break;
                default:
                    $value = $this->filterInteger($formValue);
                    if (!$value) {
                        return;
                    }

                    break;
            }

            $selectorData[$key] = $value;
        }

        $this->value = new ValueObject\DatePeriod(...$selectorData);
    }

    public function getMinYear(): int
    {
        return $this->minYear;
    }

    public function getMaxYear(): int
    {
        return $this->maxYear;
    }
}