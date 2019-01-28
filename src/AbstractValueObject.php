<?php declare(strict_types=1);

namespace LSLabs\ValueObject;

use LSLabs\ValueObject\Type\AbstractConditionalType;

abstract class AbstractValueObject
{
    abstract protected static function fromPrimitive($primitive): self;

    public function isNull(): bool
    {
        /**
         * @var AbstractConditionalType $valueObject
         */
        foreach (get_object_vars($this) as $valueObject) {
            if (!$valueObject->isNull()) {
                return false;
            }
        }

        return true;
    }
}