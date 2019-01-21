<?php declare(strict_types=1);

namespace LSLabs\ValueObject;

use LSLabs\ValueObject\Type\NullableScalarType;

trait ValueObjectTrait
{
    private $nullableScalarType;

    private function __construct(NullableScalarType $nullableScalarType)
    {
        $this->nullableScalarType = $nullableScalarType;
    }

    public static function fromPrimitive($primitive): self
    {
        if (is_scalar($primitive) && static::conditionMet($primitive)) {

            return new self(NullableScalarType::fromScalarOrNull($primitive));

        }

        return new self(NullableScalarType::fromScalarOrNull(null));
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
     * The parameter type hint (self) is very important, because it ensures that
     * only value objects of a class are comparable.
     *
     * @param $compareObject
     * @return bool
     */
    public function isSame(self $compareObject): bool
    {
        return $this->toScalarOrNull() === $compareObject->toScalarOrNull();
    }
}