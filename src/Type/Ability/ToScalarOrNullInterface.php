<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Type\Ability;

interface ToScalarOrNullInterface
{
    /**
     * @return null|bool|int|float|string
     */
    public function toScalarOrNull();
}