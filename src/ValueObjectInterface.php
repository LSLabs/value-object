<?php declare(strict_types=1);

namespace LSLabs\ValueObject;

interface ValueObjectInterface
{
    public function isNull(): bool;
}