<?php declare(strict_types=1);

namespace LSLabs\ValueObject;

use LSLabs\ValueObject\Type\NullableScalarType;

abstract class AbstractValueObject
{
    private $nullableScalarType;

    abstract protected static function conditionMet($primitive): bool;

    private function __construct(NullableScalarType $nullableScalarType)
    {
        $this->nullableScalarType = $nullableScalarType;
    }

    public static function fromPrimitive($primitive): self
    {
        if (is_scalar($primitive) && static::conditionMet($primitive)) {

            return new static(NullableScalarType::fromScalarOrNull($primitive));

        }

        return new static(NullableScalarType::fromScalarOrNull(null));
    }

    /**
     * @return bool|float|int|string|null
     */
    public function toScalarOrNull()
    {
        return $this->nullableScalarType->toScalarOrNull();
    }

    public function isNull(): bool
    {
        return $this->nullableScalarType->isNull();
    }

    /**
     * The parameter type hint (self) would be very important, because it would
     * ensure that only value objects of a class are comparable.
     *
     * @param $compareObject
     * @return bool
     */
    public function isSame(self $compareObject): bool
    {
        if (!$compareObject instanceof self) {
            return false;
        }

        return $this->toScalarOrNull() === $compareObject->toScalarOrNull();
    }
}