<?php declare(strict_types=1);

namespace LSLabs\ValueObject;

use LSLabs\ValueObject\Type\AbstractConditionalType;

abstract class AbstractValueObject
{
    private function getPrimitive($valueObject)
    {
        if ($valueObject instanceof AbstractConditionalType) {
            return $valueObject->toScalarOrNull();
        }

        /* @var AbstractValueObject $valueObject */
        return $valueObject->toArray();
    }

    abstract protected static function fromPrimitive(
        DataTransferInterface $primitive
    ): AbstractValueObject;

    public function toArray(): array
    {
        $array = [];

        foreach (get_object_vars($this) as $property => $valueObject) {
            $array[$property] = $this->getPrimitive($valueObject);
        }

        return $array;
    }

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

    public function isSame(AbstractValueObject $compareObject): bool
    {
        if (!$compareObject instanceof self) {
            return false;
        }

        return $this->toArray() === $compareObject->toArray();
    }
}