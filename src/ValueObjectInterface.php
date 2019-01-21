<?php declare(strict_types=1);

namespace LSLabs\ValueObject;

interface ValueObjectInterface
{
    /**
     * A return type hint of ValueObjectInterface results in errors if the
     * implemented classes type hint "self".
     *
     * @param $primitive
     * @return ValueObjectInterface
     */
    public static function fromPrimitive($primitive);

    public function toScalarOrNull();

    public function isNull(): bool;

    public function isSame(ValueObjectInterface $compareObject): bool;
}