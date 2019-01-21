<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Ability;

interface IsSameInterface
{
    public function isSame(ToScalarOrNullInterface $compare): bool;
}