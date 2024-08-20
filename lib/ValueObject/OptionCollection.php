<?php

namespace Kosmos\Filter\ValueObject;

use Kosmos\Filter\Structure\Collection;

class OptionCollection extends Collection
{
    public function __construct(Option ...$options)
    {
        parent::__construct();

        $this->values = $options;
    }

    public function add(Option $option): OptionCollection
    {
        $this->values[] = $option;

        return $this;
    }

    public function toArray(): array
    {
        return array_map(static fn(Option $option) => $option->toArray(), $this->values);
    }
}