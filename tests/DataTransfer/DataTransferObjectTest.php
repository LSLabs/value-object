<?php declare(strict_types=1);

namespace LSLabs\ValueObject\Tests\DataTransfer;

use LSLabs\ValueObject\DataTransfer\DataTransferObject;
use PHPUnit\Framework\TestCase;

class DataTransferObjectTest extends TestCase
{
    public function test_acts_like_public_properties(): void
    {
        $dto = new DataTransferObject();
        $dto->name = 'Roger Link';
        $dto->age = 78;

        $this->assertEquals('Roger Link', $dto->name);
        $this->assertEquals(78, $dto->age);
    }

    public function test_magic_get_ON_called_property_set_RETURNS_value(): void
    {
        $dto = new DataTransferObject();
        $dto->name = 'Roger Link';
        $dto->age = 78;

        $this->assertEquals('Roger Link', $dto->name);
        $this->assertEquals(78, $dto->age);
    }

    public function test_magic_get_ON_called_property_not_set_RETURNS_null(): void
    {
        $dto = new DataTransferObject();

        $this->assertNull($dto->name);
        $this->assertNull($dto->age);
    }
}
