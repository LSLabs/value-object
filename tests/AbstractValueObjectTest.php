<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests;

use LSLabs\ValueObject\AbstractValueObject;
use LSLabs\ValueObject\Type\AbstractConditionalType;
use PHPUnit\Framework\TestCase;

class AbstractValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function isNull_ON_all_child_value_objects_null_RETURNS_true(): void
    {
        // arrange
        $stubA = $this->createMock(AbstractConditionalType::class);
        $stubA->method('isNull')->willReturn(true);
        $stubB = $this->createMock(AbstractConditionalType::class);
        $stubB->method('isNull')->willReturn(true);
        $primitives = new CompositeDataTransferFake();
        $primitives->a = $stubA;
        $primitives->b = $stubB;
        $sut = CompositeValueObjectFake::fromPrimitive($primitives);

        // act
        $actual = $sut->isNull();

        // assert
        $this->assertTrue($actual);
    }

    /**
     * @test
     * @param bool $boolean1
     * @param bool $boolean2
     * @dataProvider notAllTrueDataProvider
     */
    public function isNull_ON_not_all_child_value_objects_null_RETURNS_false(
        bool $boolean1,
        bool $boolean2
    ): void
    {
        // arrange
        $stubA = $this->createMock(AbstractConditionalType::class);
        $stubA->method('isNull')->willReturn($boolean1);
        $stubB = $this->createMock(AbstractConditionalType::class);
        $stubB->method('isNull')->willReturn($boolean2);
        $primitives = new CompositeDataTransferFake();
        $primitives->a = $stubA;
        $primitives->b = $stubB;
        $sut = CompositeValueObjectFake::fromPrimitive($primitives);

        // act
        $actual = $sut->isNull();

        // assert
        $this->assertFalse($actual);
    }

    public function notAllTrueDataProvider(): array
    {
        return [
            [true, false],
            [false, false],
            [false, true]
        ];
    }
}

class CompositeValueObjectFake extends AbstractValueObject
{
    protected $a;

    protected $b;

    private function __construct($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public static function fromPrimitive($primitives): AbstractValueObject
    {
        /**
         * Here is the area to create own creation strategies.
         * @var CompositeDataTransferFake $primitives
         */
        return new static($primitives->a, $primitives->b);
    }
}

class CompositeDataTransferFake
{
    public $a;

    public $b;
}
