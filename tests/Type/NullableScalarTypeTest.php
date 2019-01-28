<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests\Type;

use LSLabs\ValueObject\Type\NullableScalarType;
use PHPUnit\Framework\TestCase;

class NullableScalarTypeTest extends TestCase
{
    public static function nullDataProvider(): array
    {
        return [[null]];
    }

    public static function scalarDataProvider(): array
    {
        return ScalarTypeTest::scalarDataProvider();
    }

    public static function scalarOrNullDataProvider(): array
    {
        return array_merge(
            static::scalarDataProvider(),
            static::nullDataProvider()
        );
    }

    public static function nonScalarDataProvider(): array
    {
        $array = [
            [[0, 1]],
            [['test' => 'text', 'no_test' => 'no text']]
        ];
        $object = [
            [new \stdClass()]
        ];
        $null = static::nullDataProvider();

        return array_merge($array, $object, $null);
    }

    public static function primitiveDataProvider(): array
    {
        return array_merge(
            static::scalarDataProvider(),
            static::nonScalarDataProvider()
        );
    }

    public function nonIdenticalScalarOrNullDataProvider(): array
    {
        return [
            [true, 1],
            [null, 2],
            [false, null],
            [0, 1],
            ['string', null],
            ['string', false],
            [null, 0.9932],
            ['', 0.122],
            [true, false],
            [0.123, 0.122],
            ['string', 'string ']
        ];
    }

    /**
     * @param $scalarOrNull
     * @dataProvider scalarOrNullDataProvider
     */
    public function test_fromScalarOrNull_RETURNS_self($scalarOrNull): void
    {
        $this->assertInstanceOf(
            NullableScalarType::class,
            NullableScalarType::fromScalarOrNull($scalarOrNull)
        );
    }

    /**
     * @param $primitive
     * @dataProvider primitiveDataProvider
     */
    public function test_toScalarOrNull_RETURNS_scalar_or_null($primitive): void
    {
        $expected = is_scalar($primitive) ? $primitive : null;
        $stack = NullableScalarType::fromScalarOrNull($primitive);

        $this->assertSame($expected, $stack->toScalarOrNull());
    }

    /**
     * @param $scalar
     * @dataProvider scalarDataProvider
     */
    public function test_isNull_ON_scalar_RETURNS_false($scalar): void
    {
        $stack = NullableScalarType::fromScalarOrNull($scalar);

        $this->assertFalse($stack->isNull());
    }

    /**
     * @param $nonScalar
     * @dataProvider nonScalarDataProvider
     */
    public function test_isNull_ON_non_scalar_RETURNS_true($nonScalar): void
    {
        $stack = NullableScalarType::fromScalarOrNull($nonScalar);

        $this->assertTrue($stack->isNull());
    }
}
