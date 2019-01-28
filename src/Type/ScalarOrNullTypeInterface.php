<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Type;

use LSLabs\ValueObject\Type\Ability\IsNullInterface;
use LSLabs\ValueObject\Type\Ability\ToScalarOrNullInterface;

// TODO: the ability interfaces seem not to be needed
interface ScalarOrNullTypeInterface extends
    IsNullInterface,
    ToScalarOrNullInterface
{

}