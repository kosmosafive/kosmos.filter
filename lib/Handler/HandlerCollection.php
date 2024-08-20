<?php

namespace Kosmos\Filter\Handler;

use Kosmos\Filter\Structure\Collection;

class HandlerCollection extends Collection
{
    public function add(HandlerConfig $handlerConfig): HandlerCollection
    {
        $handler = $handlerConfig->getHandler();
        $this->values[$handler->getType()][$handlerConfig->getFieldClass()] = $handler;

        return $this;
    }

    public function get(string $type, string $fieldClass): ?HandlerInterface
    {
        return $this->values[$type][$fieldClass] ?? null;
    }
}