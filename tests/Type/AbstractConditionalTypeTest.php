<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests;

use LSLabs\ValueObject\Type\AbstractConditionalType;
use PHPUnit\Framework\TestCase;

class AbstractConditionalTypeTest extends TestCase
{
    /**
     * @test
     * @param $primitive
     * @dataProvider primitiveDataProvider
     */
    public function static_fromPrimitive_WHEN_primitive_as_parameter_RETURNS_self(
        $primitive
    ): void {
        // act
        $actual = ConditionalTypeFake::fromPrimitive($primitive);

        // assert
        $this->assertInstanceOf(ConditionalTypeFake::class, $actual);
    }

    /**
     * @test
     * @param string $string
     * @dataProvider conditionMetDataProvider
     */
    public function toScalarOrNull_ON_condition_met_RETURNS_initially_scalar(
        string $string
    ): void
    {
        // arrange
        $sut = ConditionalTypeFake::fromPrimitive($string);

        // act
        $actual = $sut->toScalarOrNull();

        // assert
        $this->assertSame($string, $actual);
    }

    /**
     * @test
     * @param $primitive
     * @dataProvider conditionNotMetDataProvider
     */
    public function toScalarOrNull_ON_condition_not_met_RETURNS_null(
        $primitive
    ): void
    {
        // arrange
        $sut = ConditionalTypeFake::fromPrimitive($primitive);

        // act
        $actual = $sut->toScalarOrNull();

        // assert
        $this->assertNull($actual);
    }

    /**
     * @test
     * @param string $string
     * @dataProvider conditionMetDataProvider
     */
    public function isNull_ON_condition_met_RETURNS_false(
        string $string
    ): void
    {
        // arrange
        $sut = ConditionalTypeFake::fromPrimitive($string);

        // act
        $actual = $sut->isNull();

        // assert
        $this->assertFalse($actual);
    }

    /**
     * @test
     * @param $primitive
     * @dataProvider conditionNotMetDataProvider
     */
    public function isNull_ON_condition_not_met_RETURNS_true(
        $primitive
    ): void
    {
        // arrange
        $sut = ConditionalTypeFake::fromPrimitive($primitive);

        // act
        $actual = $sut->isNull();

        // assert
        $this->assertTrue($actual);
    }

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
}

final class ConditionalTypeFake extends AbstractConditionalType
{
    // TODO: easier fake conditionMet method with "return bool $primitive"
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