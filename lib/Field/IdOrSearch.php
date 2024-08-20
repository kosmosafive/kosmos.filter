<?php

namespace Kosmos\Filter\Field;

use Kosmos\Filter\FieldConfig;
use Kosmos\Filter\ValueObject\FormData;

class IdOrSearch extends Base
{
    public function __construct(
        FieldConfig\IdOrSearch $fieldConfig
    ) {
        parent::__construct($fieldConfig);
    }

    public function setFormValue(FormData $formData): void
    {
        $this->value = $this->filterString($formData->offsetGet($this->fieldConfig->getId()));
    }
}