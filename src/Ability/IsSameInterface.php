<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Ability;

interface IsSameInterface extends ToScalarOrNullInterface
{
    public function isSame(ToScalarOrNullInterface $compare): bool;
}