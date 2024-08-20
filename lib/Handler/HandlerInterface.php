<?php

namespace Kosmos\Filter\Handler;

use Kosmos\Filter\Field\FieldInterface;
use Kosmos\Filter\QueryBuilder\QueryBuilderInterface;
use Kosmos\Filter\ValueObject\FormData;

interface HandlerInterface
{
    public function getType(): string;

    public function apply(
        QueryBuilderInterface $queryBuilder,
        FieldInterface $field,
        FormData $formData
    ): void;
}