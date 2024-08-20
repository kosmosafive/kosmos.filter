<?php

namespace Kosmos\Filter\Structure;

abstract class Collection implements \ArrayAccess, \Iterator, \Countable
{
    protected array $values;

    public function __construct()
    {
        $this->values = [];
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        return current($this->values);
    }

    public function next(): void
    {
        next($this->values);
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        return key($this->values);
    }

    public function valid(): bool
    {
        return ($this->key() !== null);
    }

    public function rewind(): void
    {
        reset($this->values);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->values[$offset]) || array_key_exists($offset, $this->values);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        if (isset($this->values[$offset]) || array_key_exists($offset, $this->values)) {
            return $this->values[$offset];
        }

        return null;
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->values[] = $value;
        } else {
            $this->values[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->values[$offset]);
    }

    public function count(): int
    {
        return count($this->values);
    }

    public function isEmpty(): bool
    {
        return empty($this->values);
    }

    public function with(string $field, mixed $value): self
    {
        $collection = new static();

        if (empty($this->values)) {
            return $collection;
        }

        $method = null;
        $formattedField = ucfirst($field);
        if (is_bool($value)) {
            $method = 'is' . $formattedField;
        }

        $this->rewind();

        if (!$method || !method_exists($this->current(), $method)) {
            $method = 'get' . $formattedField;
        }

        if (!method_exists($this->current(), $method)) {
            return $collection;
        }

        foreach ($this->values as $obj) {
            if ($obj->$method() !== $value) {
                continue;
            }

            $collection->add($obj);
        }

        return $collection;
    }

    public function asArray(): array
    {
        return $this->values;
    }

    public function clear(): void
    {
        $this->values = [];
    }
}
