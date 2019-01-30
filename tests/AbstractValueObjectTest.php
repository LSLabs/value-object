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
        $primitives['a'] = $this->createMock(AbstractConditionalType::class);
        $primitives['b'] = $this->createMock(AbstractConditionalType::class);
        $primitives['a']->method('isNull')->willReturn(true);
        $primitives['b']->method('isNull')->willReturn(true);

        $sut = ValueObjectFake::fromPrimitive($primitives);

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
        $primitives['a'] = $this->createMock(AbstractConditionalType::class);
        $primitives['b'] = $this->createMock(AbstractConditionalType::class);
        $primitives['a']->method('isNull')->willReturn($boolean1);
        $primitives['b']->method('isNull')->willReturn($boolean2);

        $sut = ValueObjectFake::fromPrimitive($primitives);

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

class ValueObjectFake extends AbstractValueObject
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
        if (!is_array($primitives)) {
            throw new \UnexpectedValueException(
                'Inserted primitive should be an array.'
            );
        }

        /**
         * Here would be the area to create own creation strategies.
         */
        return new static($primitives['a'], $primitives['b']);
    }
}
