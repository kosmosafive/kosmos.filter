<?php

namespace Kosmos\Filter\QueryBuilder;

use Bitrix\Main\ORM\Query\Query;

class ORM extends Base
{
    protected const string TYPE = 'orm';

    public function __construct(
        protected readonly Query $query
    ) {
    }

    public function getQuery(): Query
    {
        return $this->query;
    }
}