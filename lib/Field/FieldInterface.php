<?php

namespace Kosmos\Filter\Field;

use Kosmos\Filter\FieldConfig\FieldConfigInterface;
use Kosmos\Filter\ValueObject\FormData;

interface FieldInterface extends \Stringable
{
    public function getValue(): mixed;

    public function getFieldConfig(): FieldConfigInterface;

    public function setFormValue(FormData $formData): void;
}