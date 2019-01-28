<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests\Type;

use LSLabs\ValueObject\Type\ScalarType;
use PHPUnit\Framework\TestCase;

class ScalarTypeTest extends TestCase
{
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

    /**
     * @param bool $boolean
     * @dataProvider booleanDataProvider
     */
    public function test_fromBoolean_RETURNS_self(bool $boolean): void
    {
        $this->assertInstanceOf(
            ScalarType::class,
            ScalarType::fromBoolean($boolean)
        );
    }

    /**
     * @param int $integer
     * @dataProvider integerDataProvider
     */
    public function test_fromInteger_RETURNS_self(int $integer): void
    {
        $this->assertInstanceOf(
            ScalarType::class,
            ScalarType::fromInteger($integer)
        );
    }

    /**
     * @param float $float
     * @dataProvider floatDataProvider
     */
    public function test_fromFloat_RETURNS_self(float $float): void
    {
        $this->assertInstanceOf(
            ScalarType::class,
            ScalarType::fromFloat($float)
        );
    }

    /**
     * @param string $string
     * @dataProvider stringDataProvider
     */
    public function test_fromString_RETURNS_self(string $string): void
    {
        $this->assertInstanceOf(
            ScalarType::class,
            ScalarType::fromString($string)
        );
    }

    /**
     * @param $scalar
     * @dataProvider scalarDataProvider
     * @depends test_fromBoolean_RETURNS_self
     * @depends test_fromInteger_RETURNS_self
     * @depends test_fromFloat_RETURNS_self
     * @depends test_fromString_RETURNS_self
     */
    public function test_toScalarOrNull_RETURNS_initially_scalar($scalar): void
    {
        $stack = $this->getStackFromScalar($scalar);

        $this->assertEquals($scalar, $stack->toScalarOrNull());
    }

    /**
     * @param $scalar
     * @dataProvider scalarDataProvider
     * @depends test_fromBoolean_RETURNS_self
     * @depends test_fromInteger_RETURNS_self
     * @depends test_fromFloat_RETURNS_self
     * @depends test_fromString_RETURNS_self
     */
    public function test_isNull_RETURNS_false($scalar): void
    {
        $stack = $this->getStackFromScalar($scalar);

        $this->assertFalse($stack->isNull());
    }

    private function getStackFromScalar($scalar): ScalarType
    {
        $type = 'double' === gettype($scalar) ? 'float' : gettype($scalar);
        $method = 'from' . ucfirst($type);

        return ScalarType::$method($scalar);
    }
}
