<?php

namespace Kosmos\Filter\ValueObject;

class Option
{
    public function __construct(
        public readonly string $id,
        public readonly string $label
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label
        ];
    }
}