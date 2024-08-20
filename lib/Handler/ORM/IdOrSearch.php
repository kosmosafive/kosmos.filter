<?php

namespace Kosmos\Filter\Handler\ORM;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ORM\Query;
use Kosmos\Filter\Field;
use Kosmos\Filter\QueryBuilder;
use Kosmos\Filter\ValueObject\FormData;
use Kosmos\Filter\ValueObject\PreparedPhraseDTO;

class IdOrSearch extends Base
{
    /**
     * @param QueryBuilder\ORM $queryBuilder
     * @param Field\IdOrSearch $field
     * @param FormData $formData
     * @return void
     * @throws ArgumentException
     */
    public function apply(
        QueryBuilder\QueryBuilderInterface $queryBuilder,
        Field\FieldInterface $field,
        FormData $formData
    ): void {
        $field->setFormValue($formData);
        $formValue = $field->getValue();
        if (!$formValue) {
            return;
        }

        $preparedPhraseDTO = new PreparedPhraseDTO($formValue);
        if ($preparedPhraseDTO->isInteger()) {
            $queryBuilder->getQuery()->where('ID', $preparedPhraseDTO->getOrigin());
            return;
        }

        $queryFilter = Query\Query::filter()->logic('or');

        $propertyCollection = $field->getFieldConfig()->getProperty()->getPropertyCollection();

        foreach ($propertyCollection as $property) {
            foreach ($preparedPhraseDTO->getPreparedList() as $preparedPhrase) {
                $queryFilter->whereLike($property->getName(), '%' . $preparedPhrase . '%');
            }
        }

        $queryBuilder->getQuery()->where($queryFilter);
    }
}