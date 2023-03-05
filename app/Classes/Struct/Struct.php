<?php

namespace App\Classes\Struct;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Exception;
use IteratorAggregate;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionUnionType;
use Traversable;
use TypeError;

interface StructInterface extends ArrayAccess, IteratorAggregate, Countable
{
    public function __construct();

    public static function fromArray(array $array): static;

    public static function fromArgs(array ...$items): static;

    public function __get(string $name): mixed;

    public function __set(string $name, mixed $value): never;
}

class Struct implements StructInterface
{
    final public function __construct()
    {
    }

    final public static function fromArray(array $array): static
    {
        $reflection = new ReflectionClass((new static));

        $self = (new static);

        foreach ($array as $item => $value) {
            if (! is_string($item)) {
                throw new Exception('Cannot construct '.static::class.', array keys must be string');
            }

            if (! $reflection->hasProperty($item)) {
                throw new Exception("Property $item does not exist on ".static::class);
            }

            $propertytype = $reflection->getProperty($item)->getType();
            if (is_null($propertytype)) {
                throw new Exception("Struct property $item must have named type (no union or intersection) defined.");
            }

            $property_types_array = [];

            if ($propertytype instanceof ReflectionNamedType) {
                $property_types_array[] = $propertytype->getName();
            } elseif ($propertytype instanceof ReflectionUnionType) {
                foreach ($propertytype->getTypes() as $type) {
                    $property_types_array[] = $type->getName();
                }
            } else {
                throw new TypeError('Structs can only contain named or union types.');
            }

            if (! in_array(get_debug_type($value), $property_types_array)) {
                throw new TypeError("Type of value `$item: $value` does not equal type of {$item}.");
            }

            $self->{$item} = $value;
        }

        return $self;
    }

    final public static function fromArgs(mixed ...$items): static
    {
        foreach ($items as $property => $value) {
            if (! is_string($property)) {
                throw new Exception('Cannot construct '.static::class.', named arguments are required.');
            }
        }

        return static::fromArray($items);
    }

    final public function __get(string $name): mixed
    {
        $reflection = new ReflectionClass((new static));

        if (! $reflection->hasProperty($name)) {
            throw new Exception("Property $name does not exist on ".static::class);
        }

        return $this->{$name};
    }

    final public function __set(string $name, mixed $value): never
    {
        throw new TypeError('Cannot reassign properties within Struct '.static::class);
    }

    final public function offsetExists(mixed $offset): bool
    {
        if (! is_string($offset)) {
            throw new TypeError('Struct only have properties, offset must be of type string.');
        }

        $reflection = new ReflectionClass((new static));

        return $reflection->hasProperty($offset);
    }

    final public function offsetGet(mixed $offset): mixed
    {
        if (! is_string($offset)) {
            throw new TypeError('Structs only have properties, offset must be of type string.');
        }

        return $this->__get($offset);
    }

    final public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new TypeError('Cannot reassign properties within Struct '.static::class);
    }

    final public function offsetUnset(mixed $offset): void
    {
        if (! is_string($offset)) {
            throw new TypeError('Structs only have properties, offset must be of type string.');
        }

        unset($this->{$offset});
    }

    final public function getIterator(): Traversable
    {
        $reflection = new ReflectionClass((new static));
        $reflectionproperties = $reflection->getProperties();

        $properties = [];
        foreach ($reflectionproperties as $property => $value) {
            $properties[$property] = $value;
        }

        return new ArrayIterator($properties);
    }

    final public function count(): int
    {
        $reflection = new ReflectionClass((new static));
        $reflectionproperties = $reflection->getProperties();

        return count($reflectionproperties);
    }
}
