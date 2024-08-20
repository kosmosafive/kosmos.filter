<?php

namespace Kosmos\Filter\Handler;

abstract class Base implements HandlerInterface
{
    public function getType(): string
    {
        return static::TYPE;
    }
}