<?php

namespace Kosmos\Filter\Handler;

final class HandlerConfig
{
    public function __construct(
        private readonly HandlerInterface $handler,
        private readonly string $fieldClass
    ) {
    }

    public function getHandler(): HandlerInterface
    {
        return $this->handler;
    }

    public function getFieldClass(): string
    {
        return $this->fieldClass;
    }
}