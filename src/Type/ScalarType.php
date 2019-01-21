<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Type;

use LSLabs\ValueObject\Type\Ability\ToScalarOrNullInterface;

class ScalarType implements ScalarOrNullTypeInterface
{
    private $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function fromBoolean(bool $boolean): self
    {
        return new self($boolean);
    }

    public static function fromInteger(int $integer): self
    {
        return new self($integer);
    }

    public static function fromFloat(float $float): self
    {
        return new self($float);
    }

    public static function fromString(string $string): self
    {
        return new self($string);
    }

    public function toScalarOrNull()
    {
        return $this->value;
    }

    public function isNull(): bool
    {
        return false;
    }

    public function isSame(ToScalarOrNullInterface $compare): bool
    {
        return $this->toScalarOrNull() === $compare->toScalarOrNull();
    }
}