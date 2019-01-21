<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests;

use LSLabs\ValueObject\ValueObjectTrait;
use PHPUnit\Framework\TestCase;

class ValueObjectTraitTest extends TestCase
{
    public function conditionMetDataProvider(): array
    {
        return [['1342742'], ['23'], ['193']];
    }

    public function conditionNotMetDataProvider(): array
    {
        return [['normal text'], [''], ['text'], [1], [['array']], [0.0]];
    }

    public function nonIdenticalDataProvider(): array
    {
        return [
            ['11', '10'],
            ['0', '1222249']
        ];
    }

    public function primitiveDataProvider(): array
    {
        return [
            [true],
            [false],
            [-1],
            [-0],
            [0],
            [+0],
            [1],
            [+1],
            [-0.1],
            [-0.0],
            [0.000],
            [+0.000],
            [+0.01],
            ['text'],
            ['12932932']
        ];
    }

    /**
     * @param $primitive
     * @dataProvider primitiveDataProvider
     */
    public function test_static_fromPrimitive_RETURNS_self($primitive): void
    {
        $this->assertInstanceOf(
            _ValueObjectTrait::class,
            _ValueObjectTrait::fromPrimitive($primitive)
        );
    }

    /**
     * @param string $string
     * @dataProvider conditionMetDataProvider
     */
    public function test_toScalarOrNull_ON_condition_met_RETURNS_scalar(
        string $string
    ): void
    {
        $stack = _ValueObjectTrait::fromPrimitive($string);

        $this->assertTrue(is_scalar($stack->toScalarOrNull()));
        $this->assertSame($string, $stack->toScalarOrNull());
    }

    /**
     * @param $primitive
     * @dataProvider conditionNotMetDataProvider
     */
    public function test_toScalarOrNull_ON_condition_not_met_RETURNS_null(
        $primitive
    ): void
    {
        $stack = _ValueObjectTrait::fromPrimitive($primitive);

        $this->assertNull($stack->toScalarOrNull());
    }

    /**
     * @param string $string
     * @dataProvider conditionMetDataProvider
     */
    public function test_isNull_ON_condition_met_RETURNS_false(
        string $string
    ): void
    {
        $stack = _ValueObjectTrait::fromPrimitive($string);

        $this->assertFalse($stack->isNull());
    }

    /**
     * @param $primitive
     * @dataProvider conditionNotMetDataProvider
     */
    public function test_isNull_ON_condition_not_met_RETURNS_true(
        $primitive
    ): void
    {
        $stack = _ValueObjectTrait::fromPrimitive($primitive);

        $this->assertTrue($stack->isNull());
    }

    /**
     * @param string $string
     * @dataProvider conditionMetDataProvider
     */
    public function test_isSame_ON_same_class_and_identical_toScalarOrNull_RETURNS_true(
        string $string
    ): void
    {
        $stack1 = _ValueObjectTrait::fromPrimitive($string);
        $stack2 = _ValueObjectTrait::fromPrimitive($string);

        $this->assertTrue($stack1->isSame($stack2));
    }

    /**
     * @param string $string1
     * @param string $string2
     * @dataProvider nonIdenticalDataProvider
     */
    public function test_isSame_ON_not_same_class_or_non_identical_toScalarOrNull_RETURNS_false(
        string $string1,
        string $string2
    ): void
    {
        $stack1 = _ValueObjectTrait::fromPrimitive($string1);
        $stack2 = _ValueObjectTrait::fromPrimitive($string2);

        $this->assertFalse($stack1->isSame($stack2));
    }

}

class _ValueObjectTrait
{
    use ValueObjectTrait;

    /*
     * for testing the condition is to have an integer(ish) string
     */
    private static function conditionMet($primitive): bool
    {
        if (!is_string($primitive) OR !preg_match('/^[0-9]+$/', $primitive)) {
            return false;
        }

        return true;
    }
}
