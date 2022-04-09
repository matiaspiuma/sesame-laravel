<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Infrastructure\Utils;

use Api\V1\SharedContext\Infrastructure\Utils\CollectionProxy;

class Collection implements \ArrayAccess, \Countable
{
    protected array $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function first(): mixed
    {
        if (empty($this->items)) {
            return null;
        }

        return $this->items[0];
    }

    public function mapInto($class)
    {
        return $this->map(function ($value, $key) use ($class) {
            return new $class($value, $key);
        });
    }

    public function map(callable $callback)
    {
        $keys = array_keys(array: $this->items);

        $items = array_map($callback, $this->items, $keys);

        return new static(array_combine($keys, $items));
    }

    public function toArray(): array
    {
        return \array_map(
            fn ($value) => $value instanceof Arrayable ? $value->toArray() : $value,
            $this->items
        );
    }

    public function all()
    {
        return $this->items;
    }

    public function offsetExists($key): bool
    {
        return isset($this->items[$key]);
    }

    public function offsetGet($key): mixed
    {
        return $this->items[$key];
    }

    public function offsetSet($key, $value): void
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    public function offsetUnset($key): void
    {
        unset($this->items[$key]);
    }


    public function __get($name)
    {
        switch ($name) {
            case "map":
                return new CollectionProxy(
                    collection: new self($this->items),
                    method: $name
                );
                break;
        }
        return null;
    }
}
