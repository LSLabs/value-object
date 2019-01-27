<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests\Type;

use LSLabs\ValueObject\Type\NullType;
use LSLabs\ValueObject\Type\Ability\ToScalarOrNullInterface;
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

    public function test_isSame_ON_same_class_and_identical_toScalarOrNull_RETURNS_true(): void
    {
        $mock = $this->createMock(NullType::class);
        $mock->method('toScalarOrNull')->willReturn(null);

        $this->assertTrue($this->stack->isSame($mock));
        $this->assertTrue($this->stack->isSame($this->stack));
    }

    public function test_isSame_ON_not_same_class_RETURNS_false(): void
    {
        $mock = $this->createMock(ToScalarOrNullInterface::class);

        $this->assertFalse($this->stack->isSame($mock));
    }
}
