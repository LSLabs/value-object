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
        $compareObject = new NullType();

        $this->assertTrue($this->stack->isSame($compareObject));
    }

    public function test_isSame_ON_not_same_class_RETURNS_false(): void
    {
        $dummy = $this->createMock(ToScalarOrNullInterface::class);

        $this->assertFalse($this->stack->isSame($dummy));
    }
}
