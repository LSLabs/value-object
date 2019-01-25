<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests;

use LSLabs\ValueObject\AbstractValueObject;
use LSLabs\ValueObject\Type\AbstractConditionalType;
use LSLabs\ValueObject\DataTransferInterface;
use PHPUnit\Framework\TestCase;

class AbstractValueObjectTest extends TestCase
{
    public function notAllTrueDataProvider(): array
    {
        return [
            [true, false],
            [false, false],
            [false, true]
        ];
    }

    public function test_isNull_ON_all_child_value_objects_are_null_RETURNS_true(): void
    {
        $primitives = new CompositeDataTransfer();
        $primitives->a = $this->createMock(AbstractConditionalType::class);
        $primitives->a->method('isNull')->willReturn(true);
        $primitives->b = $this->createMock(AbstractConditionalType::class);
        $primitives->b->method('isNull')->willReturn(true);
        $stack = CompositeValueObject::fromPrimitive($primitives);

        $this->assertTrue($stack->isNull());
    }

    /**
     * @param bool $boolean1
     * @param bool $boolean2
     * @dataProvider notAllTrueDataProvider
     */
    public function test_isNull_ON_not_all_child_value_objects_are_null_RETURNS_false(
        bool $boolean1,
        bool $boolean2
    ): void
    {
        $primitives = new CompositeDataTransfer();
        $primitives->a = $this->createMock(AbstractConditionalType::class);
        $primitives->a->method('isNull')->willReturn($boolean1);
        $primitives->b = $this->createMock(AbstractConditionalType::class);
        $primitives->b->method('isNull')->willReturn($boolean2);
        $stack = CompositeValueObject::fromPrimitive($primitives);

        $this->assertFalse($stack->isNull());
    }

    public function test_toArray_RETURNS_an_array_list(): void
    {
        $scalar1 = 'test';
        $scalar2 = 1;
        $scalar3 = true;
        $array = ['c' => $scalar2, 'd' => $scalar3];
        $primitives = new CompositeDataTransfer();
        $primitives->a = $this->createMock(AbstractConditionalType::class);
        $primitives->a->method('toScalarOrNull')->willReturn($scalar1);
        $primitives->b = $this->createMock(AbstractValueObject::class);
        $primitives->b->method('toArray')->willReturn($array);
        $stack = CompositeValueObject::fromPrimitive($primitives);

        $this->assertEquals(
            [
                'a' => $scalar1,
                'c' => $scalar2,
                'd' => $scalar3
            ],
            $stack->toArray()
        );
    }

    public function test_isSame_ON_identical_toArray_RETURNS_true(): void
    {
        $scalar1 = 'test';
        $scalar2 = 1;
        $scalar3 = true;
        $array = ['c' => $scalar2, 'd' => $scalar3];

        $primitives = new CompositeDataTransfer();
        $primitives->a = $this->createMock(AbstractConditionalType::class);
        $primitives->a->method('toScalarOrNull')->willReturn($scalar1);

        $primitives->b = $this->createMock(AbstractValueObject::class);
        $primitives->b->method('toArray')->willReturn($array);
        $stack = CompositeValueObject::fromPrimitive($primitives);

        $mockArray = [
            'a' => 'test',
            'c' => 1,
            'd' => true
        ];
        $mock = $this->createMock(AbstractValueObject::class);
        $mock->method('toArray')->willReturn($mockArray);

        $this->assertTrue($stack->isSame($mock));
    }

    public function test_isSame_ON_not_identical_toArray_RETURNS_false(): void
    {
        $scalar1 = 'test';
        $scalar2 = 1;
        $scalar3 = true;
        $array = ['c' => $scalar2, 'd' => $scalar3];

        $primitives = new CompositeDataTransfer();
        $primitives->a = $this->createMock(AbstractConditionalType::class);
        $primitives->a->method('toScalarOrNull')->willReturn($scalar1);

        $primitives->b = $this->createMock(AbstractValueObject::class);
        $primitives->b->method('toArray')->willReturn($array);
        $stack = CompositeValueObject::fromPrimitive($primitives);

        $mockArray = [
            'a' => 'test',
            'c' => 1,
            'd' => false
        ];
        $mock = $this->createMock(AbstractValueObject::class);
        $mock->method('toArray')->willReturn($mockArray);

        $this->assertFalse($stack->isSame($mock));
    }
}

class CompositeValueObject extends AbstractValueObject
{
    protected $a;

    protected $b;

    private function __construct($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public static function fromPrimitive(
        DataTransferInterface $primitives
    ): AbstractValueObject
    {
        /**
         * Here is the area to create own creation strategies.
         * @var CompositeDataTransfer $primitives
         */
        return new static($primitives->a, $primitives->b);
    }
}

class CompositeDataTransfer implements DataTransferInterface
{
    public $a;

    public $b;
}
