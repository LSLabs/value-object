<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests;

use LSLabs\ValueObject\Type\AbstractConditionalType;
use PHPUnit\Framework\TestCase;

class AbstractConditionalTypeTest extends TestCase
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
            ConditionalTypeFake::class,
            ConditionalTypeFake::fromPrimitive($primitive)
        );
    }

    /**
     * @param string $string
     * @dataProvider conditionMetDataProvider
     */
    public function test_toScalarOrNull_ON_condition_met_RETURNS_initially_scalar(
        string $string
    ): void
    {
        $stack = ConditionalTypeFake::fromPrimitive($string);

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
        $stack = ConditionalTypeFake::fromPrimitive($primitive);

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
        $stack = ConditionalTypeFake::fromPrimitive($string);

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
        $stack = ConditionalTypeFake::fromPrimitive($primitive);

        $this->assertTrue($stack->isNull());
    }
}

final class ConditionalTypeFake extends AbstractConditionalType
{
    /*
     * for testing the condition is to have an integer(ish) string
     */
    protected static function conditionMet($primitive): bool
    {
        if (!is_string($primitive) OR !preg_match('/^[0-9]+$/', $primitive)) {
            return false;
        }

        return true;
    }
}