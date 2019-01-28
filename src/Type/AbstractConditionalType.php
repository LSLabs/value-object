<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Type;

abstract class AbstractConditionalType
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
}