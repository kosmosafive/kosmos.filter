<?php

namespace Kosmos\Filter\Field;

use Bitrix\Main\Type;
use Kosmos\Filter\FieldConfig;
use Kosmos\Filter\ValueObject;

class DateRange extends Base
{
    public function __construct(
        FieldConfig\Simple $fieldConfig,
        protected readonly ?Type\Datetime $minDate = null,
        protected readonly ?Type\Datetime $maxDate = null,
        protected readonly bool $dateOnly = true
    ) {
        parent::__construct($fieldConfig);

        $this->value = new ValueObject\Range();
    }

    public function setFormValue(ValueObject\FormData $formData): void
    {
        $formValue = [];

        foreach (['from', 'to'] as $key) {
            $value = $formData->offsetGet($this->fieldConfig->getId() . '_' . $key);
            if (!$value) {
                $formValue[$key] = null;
                continue;
            }

            $filteredValue = Type\DateTime::tryParse($value, DATE_ATOM);
            if ($filteredValue) {
                $filteredValue->setTime(0, 0);

                if ($key === 'to') {
                    $filteredValue->add('1 day');
                }

                if (
                    (
                        $this->minDate
                        && ($filteredValue->getTimestamp() < $this->minDate->getTimestamp())
                    )
                    || (
                        $this->maxDate->getTimestamp()
                        && ($filteredValue->getTimestamp() > $this->maxDate->getTimestamp())
                    )
                ) {
                    $filteredValue = null;
                }
            }

            $formValue[$key] = $filteredValue;
        }

        $this->value = new ValueObject\Range(...$formValue);
    }

    public function getMinDate(): ?Type\Datetime
    {
        return $this->minDate;
    }

    public function getMaxDate(): ?Type\Datetime
    {
        return $this->maxDate;
    }

    public function isDateOnly(): bool
    {
        return $this->dateOnly;
    }
}