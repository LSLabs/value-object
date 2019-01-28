<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Type;

use LSLabs\ValueObject\Type\Ability\ToScalarOrNullInterface;

class NullableScalarType implements ToScalarOrNullInterface
{
    private $scalarOrNullType;

    private function __construct(ScalarOrNullTypeInterface $type)
    {
        $this->scalarOrNullType = $type;
    }

    public static function fromScalarOrNull($scalarOrNull): self
    {
        if (is_scalar($scalarOrNull)) {
            $scalarType = static::getScalarType($scalarOrNull);

            return new self($scalarType);
        }

        return new self(new NullType());
    }

    public function toScalarOrNull()
    {
        return $this->scalarOrNullType->toScalarOrNull();
    }

    public function isNull(): bool
    {
        return $this->scalarOrNullType->isNull();
    }

    private static function getScalarType($scalar): ScalarType
    {
        $type = 'double' === gettype($scalar) ? 'float' : gettype($scalar);
        $method = 'from' . ucfirst($type);

        return ScalarType::$method($scalar);
    }
}