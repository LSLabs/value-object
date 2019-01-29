<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests\Type;

use LSLabs\ValueObject\Type\NullType;
use PHPUnit\Framework\TestCase;

class NullTypeTest extends TestCase
{
    /**
     * @test
     */
    public function construct_RETURNS_self(): void
    {
        // act
        $actual = new NullType();

        // assert
        $this->assertInstanceOf(NullType::class, $actual);
    }

    /**
     * @test
     */
    public function toScalarOrNull_RETURNS_null(): void
    {
        // arrange
        $sut = new NullType();

        // action
        $actual = $sut->toScalarOrNull();

        // assert
        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function isNull_RETURNS_true(): void
    {
        // arrange
        $sut = new NullType();

        // act
        $actual = $sut->isNull();

        // assert
        $this->assertTrue($actual);
    }
}
