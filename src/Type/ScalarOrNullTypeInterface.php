<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Type;

use LSLabs\ValueObject\Ability\IsNullInterface;
use LSLabs\ValueObject\Ability\IsSameInterface;

interface ScalarOrNullTypeInterface extends
    IsNullInterface,
    IsSameInterface
{

}