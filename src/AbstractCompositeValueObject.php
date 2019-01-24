<?php declare(strict_types=1);

namespace LSLabs\ValueObject;

abstract class AbstractCompositeValueObject implements ValueObjectInterface
{
    private function getPrimitive(ValueObjectInterface $valueObject)
    {
        if ($valueObject instanceof AbstractValueObject) {
            return $valueObject->toScalarOrNull();
        }

        /* @var AbstractCompositeValueObject $valueObject */
        return $valueObject->toArray();
    }

    abstract protected static function fromPrimitive(
        DataTransferInterface $primitive
    ): AbstractCompositeValueObject;

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
         * @var AbstractValueObject $valueObject
         */
        foreach (get_object_vars($this) as $valueObject) {
            if (!$valueObject->isNull()) {
                return false;
            }
        }

        return true;
    }

    public function isSame(AbstractCompositeValueObject $compareObject): bool
    {
        if (!$compareObject instanceof self) {
            return false;
        }

        return $this->toArray() === $compareObject->toArray();
    }
}