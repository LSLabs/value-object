<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Type\Ability;

use LSLabs\ValueObject\Type\Ability\ToScalarOrNullInterface;

interface IsSameInterface extends ToScalarOrNullInterface
{
    public function isSame(ToScalarOrNullInterface $compare): bool;
}