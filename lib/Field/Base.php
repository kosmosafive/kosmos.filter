<?php

namespace Kosmos\Filter\Field;

use Kosmos\Filter\FieldConfig\FieldConfigInterface;

abstract class Base implements FieldInterface
{
    protected mixed $value = null;

    public function __construct(
        protected readonly FieldConfigInterface $fieldConfig
    ) {
    }

    public function __toString(): string
    {
        return static::class;
    }

    public function setValue(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    protected function filterString(mixed $value = null): ?string
    {
        if (!$value) {
            return null;
        }

        $filteredValue = strip_tags($value);
        $filteredValue = filter_var($filteredValue, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE | FILTER_FLAG_STRIP_LOW);
        $regex = '/[^\p{Cyrillic}\p{Latin}\p{Common}]/u';
        $filteredValue = preg_replace($regex, '', $filteredValue);
        return trim($filteredValue);
    }

    protected function filterInteger(mixed $value = null, int $min = null, int $max = null): ?int
    {
        if (!$value) {
            return null;
        }

        $options = [];

        if ($min) {
            $options['min_range'] = $min;
        }

        if ($max) {
            $options['max_range'] = $max;
        }

        return filter_var(
            $value,
            FILTER_VALIDATE_INT,
            [
                'flags' => FILTER_NULL_ON_FAILURE,
                'options' => $options
            ]
        );
    }

    protected function filterBoolean(mixed $value): bool
    {
        return ($value === 'true')
            || ((int)$value === 1)
            || ($value === 'on')
            || ($value === 'Y')
            || ($value === 'y')
            || ($value === 'yes');
    }

    public function getFieldConfig(): FieldConfigInterface
    {
        return $this->fieldConfig;
    }
}