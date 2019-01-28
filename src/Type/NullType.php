<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Type;

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
}