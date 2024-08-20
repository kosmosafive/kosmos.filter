<?php

namespace Kosmos\Filter\Field;

use Kosmos\Filter\FieldConfig\FieldConfigInterface;
use Kosmos\Filter\ValueObject\OptionCollection;

class Select extends Text
{
    public function __construct(
        FieldConfigInterface $fieldConfig,
        protected readonly OptionCollection $optionCollection
    ) {
        parent::__construct($fieldConfig);
    }

    public function getOptionCollection(): OptionCollection
    {
        return $this->optionCollection;
    }

    protected function filterValue(mixed $value): ?string
    {
        $filteredValue = $this->filterString($value);
        if (!$filteredValue) {
            return null;
        }

        return (!($this->optionCollection->with('id', $filteredValue)->isEmpty())) ? $filteredValue : null;
    }
}