<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests\Type;

use LSLabs\ValueObject\Type\ScalarType;
use PHPUnit\Framework\TestCase;

class ScalarTypeTest extends TestCase
{
    /**
     * @test
     * @param bool $boolean
     * @dataProvider booleanDataProvider
     */
    public function static_fromBoolean_WHEN_boolean_as_parameter_RETURNS_self(
        bool $boolean
    ): void {
        // act
        $actual = ScalarType::fromBoolean($boolean);

        // assert
        $this->assertInstanceOf(ScalarType::class, $actual);
    }

    /**
     * @test
     * @param int $integer
     * @dataProvider integerDataProvider
     */
    public function static_fromInteger_WHEN_integer_as_parameter_RETURNS_self(
        int $integer
    ): void {
        // act
        $actual = ScalarType::fromInteger($integer);

        // assert
        $this->assertInstanceOf(ScalarType::class, $actual);
    }

    /**
     * @test
     * @param float $float
     * @dataProvider floatDataProvider
     */
    public function static_fromFloat_WHEN_float_as_parameter_RETURNS_self(
        float $float
    ): void {
        // act
        $actual = ScalarType::fromFloat($float);

        // assert
        $this->assertInstanceOf(ScalarType::class, $actual);
    }

    /**
     * @test
     * @param string $string
     * @dataProvider stringDataProvider
     */
    public function static_fromString_WHEN_string_as_parameter_RETURNS_self(
        string $string
    ): void {
        // act
        $actual = ScalarType::fromString($string);

        // assert
        $this->assertInstanceOf(ScalarType::class, $actual);
    }

    /**
     * @test
     * @param $scalar
     * @dataProvider scalarDataProvider
     * @depends static_fromBoolean_WHEN_boolean_as_parameter_RETURNS_self
     * @depends static_fromFloat_WHEN_float_as_parameter_RETURNS_self
     * @depends static_fromInteger_WHEN_integer_as_parameter_RETURNS_self
     * @depends static_fromString_WHEN_string_as_parameter_RETURNS_self
     */
    public function toScalarOrNull_RETURNS_initially_scalar($scalar): void
    {
        // arrange
        $sut = $this->getSutFromScalar($scalar);

        // act
        $actual = $sut->toScalarOrNull();

        // assert
        $this->assertEquals($scalar, $actual);
    }

    /**
     * @test
     * @param $scalar
     * @dataProvider scalarDataProvider
     * @depends static_fromBoolean_WHEN_boolean_as_parameter_RETURNS_self
     * @depends static_fromFloat_WHEN_float_as_parameter_RETURNS_self
     * @depends static_fromInteger_WHEN_integer_as_parameter_RETURNS_self
     * @depends static_fromString_WHEN_string_as_parameter_RETURNS_self
     */
    public function isNull_RETURNS_false($scalar): void
    {
        // arrange
        $sut = $this->getSutFromScalar($scalar);

        // act
        $actual = $sut->isNull();

        // assert
        $this->assertFalse($actual);
    }

    public static function booleanDataProvider(): array
    {
        return [[true], [false]];
    }

    public static function integerDataProvider(): array
    {
        return [[-1], [0], [1], [+1]];
    }

    public static function floatDataProvider(): array
    {
        return [[-1.00], [-0.1], [-0.00], [0.00], [+0.00], [+0.1], [+1.1]];
    }

    public static function stringDataProvider(): array
    {
        return [[''], ['text'], ['##?``12  ']];
    }

    public static function scalarDataProvider(): array
    {
        $boolean = static::booleanDataProvider();
        $integer = static::integerDataProvider();
        $float = static::floatDataProvider();
        $string = static::stringDataProvider();

        return array_merge($boolean, $integer, $float, $string);
    }

    public function nonIdenticalScalarDataProvider(): array
    {
        return [
            [true, 1],
            [0, 1],
            ['string', false],
            ['', 0.122],
            [true, false],
            [0.123, 0.122],
            ['string', 'string ']
        ];
    }

    private function getSutFromScalar($scalar): ScalarType
    {
        $type = 'double' === gettype($scalar) ? 'float' : gettype($scalar);
        $method = 'from' . ucfirst($type);

        return ScalarType::$method($scalar);
    }
}
