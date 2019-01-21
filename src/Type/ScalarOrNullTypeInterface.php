<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Type;

use LSLabs\ValueObject\Ability\IsNullInterface;
use LSLabs\ValueObject\Ability\IsSameInterface;
use LSLabs\ValueObject\Ability\ToScalarOrNullInterface;

interface ScalarOrNullTypeInterface extends
    ToScalarOrNullInterface,
    IsNullInterface,
    IsSameInterface
{

}