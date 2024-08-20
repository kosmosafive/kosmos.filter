<?php

namespace Kosmos\Filter\Handler\ORM;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ORM\Query\Query;
use Kosmos\Filter\Field\DateRange;
use Kosmos\Filter\Field\FieldInterface;
use Kosmos\Filter\QueryBuilder;
use Kosmos\Filter\ValueObject\FormData;

class Range extends Base
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
        $rangeValue = $field->getValue();

        if ($rangeValue->getFrom() && $rangeValue->getTo()) {
            if ($rangeValue->getFrom() === $rangeValue->getTo()) {
                $queryBuilder->getQuery()->where(
                    $field->getFieldConfig()->getProperty()->getName(),
                    $rangeValue->getFrom()
                );
            } elseif ($field instanceof DateRange) {
                $queryBuilder->getQuery()->where(
                    Query::filter()
                        ->logic('and')
                        ->where(
                            $field->getFieldConfig()->getProperty()->getName(),
                            '>=',
                            $rangeValue->getFrom()
                        )
                        ->where(
                            $field->getFieldConfig()->getProperty()->getName(),
                            '<',
                            $rangeValue->getTo()
                        )
                );
            } else {
                $queryBuilder->getQuery()->whereBetween(
                    $field->getFieldConfig()->getProperty()->getName(),
                    $rangeValue->getFrom(),
                    $rangeValue->getTo()
                );
            }

            return;
        }

        if ($rangeValue->getFrom()) {
            $queryBuilder->getQuery()->where(
                $field->getFieldConfig()->getProperty()->getName(),
                '>=',
                $rangeValue->getFrom()
            );
            return;
        }

        if ($rangeValue->getTo()) {
            $queryBuilder->getQuery()->where(
                $field->getFieldConfig()->getProperty()->getName(),
                '<=',
                $rangeValue->getTo()
            );
            return;
        }
    }
}