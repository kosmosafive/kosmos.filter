<?php

namespace Kosmos\Filter\Handler\ORM;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ORM\Query\Query;
use Kosmos\Filter\Field\FieldInterface;
use Kosmos\Filter\QueryBuilder;
use Kosmos\Filter\ValueObject\FormData;

class Contains extends Base
{
    /**
     * @param QueryBuilder\ORM $queryBuilder
     * @param FieldInterface $field
     * @param FormData $formData
     * @return void
     * @throws ArgumentException
     */
    public function apply(
        QueryBuilder\QueryBuilderInterface $queryBuilder,
        FieldInterface $field,
        FormData $formData
    ): void {
        $field->setFormValue($formData);
        $formValue = $field->getValue();
        if (!$formValue) {
            return;
        }

        $propertyName = $field->getFieldConfig()->getProperty()->getName();

        if (is_array($formValue)) {
            $queryFilter = Query::filter()->logic('or');

            foreach ($formValue as $singleValue) {
                $queryFilter->whereLike($propertyName, $singleValue);
            }

            $queryBuilder->getQuery()->where($queryFilter);
        } else {
            $queryBuilder->getQuery()->whereLike($propertyName, $formValue);
        }
    }
}