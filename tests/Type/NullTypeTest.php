<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests\Type;

use LSLabs\ValueObject\Type\NullType;
use PHPUnit\Framework\TestCase;

class NullTypeTest extends TestCase
{
    /**
     * @var \LSLabs\ValueObject\Type\NullType
     */
    private $stack;

    public function setUp()
    {
        $this->stack = new NullType();
    }

    public function test_toScalarOrNull_RETURNS_null(): void
    {
        $this->assertNull($this->stack->toScalarOrNull());
    }

    public function test_isNull_RETURNS_true(): void
    {
        $this->assertTrue($this->stack->isNull());
    }
}
