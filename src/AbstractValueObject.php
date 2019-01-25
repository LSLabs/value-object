<?php declare(strict_types=1);

namespace LSLabs\ValueObject;

use LSLabs\ValueObject\Type\AbstractConditionalType;

abstract class AbstractValueObject
{
    abstract protected static function fromPrimitive($primitive): self;

    public function toArray(): array
    {
        $array = [];

        foreach (get_object_vars($this) as $property => $value) {
            if ($value instanceof self) {
                $subArray = $value->toArray();
                $array = array_merge($array, $subArray);
            }

            if ($value instanceof AbstractConditionalType) {
                $array[$property] = $value->toScalarOrNull();
            }

        }

        return $array;
    }

    public function isNull(): bool
    {
        /**
         * @var AbstractConditionalType $valueObject
         */
        foreach (get_object_vars($this) as $valueObject) {
            if (!$valueObject->isNull()) {
                return false;
            }
        }

        return true;
    }

    public function isSame(AbstractValueObject $compareObject): bool
    {
        // TODO: test this if-clause
        if (!$compareObject instanceof self) {
            return false;
        }

        return $this->toArray() === $compareObject->toArray();
    }
}