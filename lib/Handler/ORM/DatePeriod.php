<?php

namespace Kosmos\Filter\Handler\ORM;

use Kosmos\Filter\Field\FieldInterface;
use Kosmos\Filter\ValueObject\FormData;
use Kosmos\Filter\QueryBuilder;
use Kosmos\Filter\FieldConfig\Property;

class DatePeriod extends Base
{
    public function apply(
        QueryBuilder\QueryBuilderInterface $queryBuilder,
        FieldInterface $field,
        FormData $formData
    ): void {
        $field->setFormValue($formData);
        $formValue = $field->getValue();
        if ($formValue->isEmpty()) {
            return;
        }

        /**
         * @var Property\DatePeriod $property
         */
        $property = $field->getFieldConfig()->getProperty();

        $queryBuilder->getQuery()->where($property->getYear(), $formValue->getYear());

        if ($formValue->getQuarter()) {
            $queryBuilder->getQuery()->where($property->getQuarter(), $formValue->getQuarter());
        } elseif ($formValue->getMonth()) {
            $queryBuilder->getQuery()->where($property->getMonth(), $formValue->getMonth());
        }
    }
}