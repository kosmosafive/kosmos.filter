<?php

namespace Kosmos\Filter\Handler\ORM;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ORM\Query\Query;
use Kosmos\Filter\Field\FieldInterface;
use Kosmos\Filter\QueryBuilder;
use Kosmos\Filter\ValueObject\FormData;
use Kosmos\Filter\FieldConfig\Property;

class Equal extends Base
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
        if (
            (
                is_array($formValue)
                && empty($formValue)
            )
            || ($formValue === null)
        ) {
            return;
        }

        $queryMethod = $this->getQueryMethod($formValue);

        $property = $field->getFieldConfig()->getProperty();

        if ($property instanceof Property\Multiple) {
            $this->applyForMultipleProperty(
                $queryBuilder,
                $queryMethod,
                $property,
                $formValue
            );
            return;
        }

        if ($property instanceof Property\Single) {
            $this->applyForSingleProperty(
                $queryBuilder,
                $queryMethod,
                $property,
                $formValue
            );
            return;
        }
    }

    protected function getQueryMethod(mixed $formValue): string
    {
        return (is_array($formValue)) ? 'whereIn' : 'where';
    }

    /**
     * @throws ArgumentException
     */
    protected function applyForMultipleProperty(
        QueryBuilder\QueryBuilderInterface $queryBuilder,
        string $queryMethod,
        Property\Multiple $property,
        mixed $formValue
    ): void {
        $queryFilter = Query::filter()->logic('or');

        foreach ($property->getPropertyCollection() as $singleProperty) {
            $queryFilter->$queryMethod($singleProperty->getName(), $formValue);
        }

        $queryBuilder->getQuery()->where($queryFilter);
    }

    protected function applyForSingleProperty(
        QueryBuilder\QueryBuilderInterface $queryBuilder,
        string $queryMethod,
        Property\Single $property,
        mixed $formValue
    ): void {
        $queryBuilder->getQuery()->$queryMethod($property->getName(), $formValue);
    }
}