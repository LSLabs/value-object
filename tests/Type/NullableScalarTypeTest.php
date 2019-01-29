<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests\Type;

use LSLabs\ValueObject\Type\NullableScalarType;
use PHPUnit\Framework\TestCase;

class NullableScalarTypeTest extends TestCase
{
    /**
     * @test
     * @param $scalarOrNull
     * @dataProvider scalarOrNullDataProvider
     */
    public function static_fromScalarOrNull_WHEN_scalar_or_null_as_parameter_RETURNS_self(
        $scalarOrNull
    ): void {
        // act
        $actual = NullableScalarType::fromScalarOrNull($scalarOrNull);

        // assert
        $this->assertInstanceOf(NullableScalarType::class, $actual);
    }

    /**
     * @test
     * @param $primitive
     * @dataProvider primitiveDataProvider
     */
    public function toScalarOrNull_RETURNS_scalar_or_null($primitive): void
    {
        // arrange
        $expected = is_scalar($primitive) ? $primitive : null;
        $sut = NullableScalarType::fromScalarOrNull($primitive);

        // act
        $actual = $sut->toScalarOrNull();

        // assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     * @param $scalar
     * @dataProvider scalarDataProvider
     */
    public function isNull_ON_instance_from_scalar_RETURNS_false($scalar): void
    {
        // arrange
        $sut = NullableScalarType::fromScalarOrNull($scalar);

        // act
        $actual = $sut->isNull();

        // assert
        $this->assertFalse($actual);
    }

    /**
     * @test
     * @param $nonScalar
     * @dataProvider nonScalarDataProvider
     */
    public function isNull_ON_instance_from_non_scalar_RETURNS_true(
        $nonScalar
    ): void {
        // arrange
        $sut = NullableScalarType::fromScalarOrNull($nonScalar);

        // act
        $actual = $sut->isNull();

        // assert
        $this->assertTrue($actual);
    }

    public function nullDataProvider(): array
    {
        return [[null]];
    }

    public function scalarDataProvider(): array
    {
        return ScalarTypeTest::scalarDataProvider();
    }

    public function scalarOrNullDataProvider(): array
    {
        return array_merge(
            static::scalarDataProvider(),
            static::nullDataProvider()
        );
    }

    public function nonScalarDataProvider(): array
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

    public function primitiveDataProvider(): array
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
}
