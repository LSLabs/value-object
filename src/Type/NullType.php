<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Type;

use LSLabs\ValueObject\Type\Ability\ToScalarOrNullInterface;

class NullType implements ScalarOrNullTypeInterface
{
    public function toScalarOrNull()
    {
        return null;
    }

    public function isNull(): bool
    {
        return true;
    }

    public function isSame(ToScalarOrNullInterface $compare): bool
    {
        return $this->toScalarOrNull() === $compare->toScalarOrNull();
    }
}