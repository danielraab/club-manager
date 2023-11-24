<?php

namespace Tests\Feature\Configuration;

use App\Models\Configuration;
use App\Models\User;
use League\Flysystem\Config;
use Tests\TestCase;
use function PHPUnit\Framework\assertSame;

class ModalTest extends TestCase
{
    public function test_get_missing_configs(): void
    {
        $this->assertNull(Configuration::getString("string_key"));
        $this->assertNull(Configuration::getInt("int_key"));
        $this->assertNull(Configuration::getBool("bool_key"));

        $user = User::factory()->create();
        $this->assertSame("default", Configuration::getString("string_key", $user, "default"));
        $this->assertSame(546231, Configuration::getInt("int_key", $user, 546231));
        $this->assertTrue(Configuration::getBool("bool_key", $user, true));
    }

    public function test_store_and_get_global(): void
    {
        $this->assertNull(Configuration::storeString("string_key", "string_value_1"));
        $this->assertSame("string_value_1", Configuration::storeString("string_key", "string_value_2"));
        $this->assertSame("string_value_2", Configuration::getString("string_key"));

        $this->assertNull(Configuration::storeInt("int_key", 345234));
        $this->assertSame(345234, Configuration::storeInt("int_key", 465465));
        $this->assertSame(465465, Configuration::getInt("int_key"));

        $this->assertNull(Configuration::storeBool("bool_key", true));
        $this->assertTrue(Configuration::storeBool("bool_key", false));
        $this->assertFalse(Configuration::getBool("bool_key"));
    }

    public function test_store_and_get_user(): void
    {
        $user = User::factory()->create();
        $this->assertNull(Configuration::storeString("string_key", "string_value_1", $user));
        $this->assertSame("string_value_1", Configuration::storeString("string_key", "string_value_2", $user));
        $this->assertSame("string_value_2", Configuration::getString("string_key", $user));

        $this->assertNull(Configuration::storeInt("int_key", 345234, $user));
        $this->assertSame(345234, Configuration::storeInt("int_key", 465465, $user));
        $this->assertSame(465465, Configuration::getInt("int_key", $user));

        $this->assertNull(Configuration::storeBool("bool_key", true, $user));
        $this->assertTrue(Configuration::storeBool("bool_key", false, $user));
        $this->assertFalse(Configuration::getBool("bool_key", $user));
    }

    public function test_store_global_and_get_user(): void
    {
        $user = User::factory()->create();
        $this->assertNull(Configuration::storeString("string_key1", "string_global_value_1"));
        $this->assertSame("string_global_value_1", Configuration::getString("string_key1", $user));

        $this->assertNull(Configuration::storeInt("int_key1", 345234));
        $this->assertSame(345234, Configuration::getInt("int_key1", $user));

        $this->assertNull(Configuration::storeBool("bool_key1", true));
        $this->assertTrue(Configuration::getBool("bool_key1", $user));
    }

    public function test_store_and_get_multiple_user(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $this->assertNull(Configuration::storeString("string_key2", "string_global_value_1"));
        $this->assertNull(Configuration::storeString("string_key2", "string_user_value_1", $user));
        $this->assertNull(Configuration::storeString("string_key2", "string_user2_value_1", $user2));
        $this->assertNull(Configuration::storeString("string_key3", "string_global3_value_1"));

        $this->assertSame("string_global_value_1", Configuration::storeString("string_key2", "string_global_value_2"));
        $this->assertSame("string_user_value_1", Configuration::storeString("string_key2", "string_user_value_2", $user));
        $this->assertSame("string_user2_value_1", Configuration::storeString("string_key2", "string_user2_value_2", $user2));

        $this->assertSame("string_global_value_2", Configuration::getString("string_key2"));
        $this->assertSame("string_user_value_2", Configuration::getString("string_key2", $user));
        $this->assertSame("string_user2_value_2", Configuration::getString("string_key2", $user2));

        $this->assertSame("string_global3_value_1", Configuration::getString("string_key3", $user));
        $this->assertSame("string_global3_value_1", Configuration::getString("string_key3", $user2));

    }
}
