<?php

namespace Tests\Feature\Configuration;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModalTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_missing_configs(): void
    {
        $this->assertNull(Configuration::getString(ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST));
        $this->assertNull(Configuration::getInt(ConfigurationKey::DASHBOARD_BTN_IMPORT_MEMBERS));
        $this->assertNull(Configuration::getBool(ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE));

        $user = User::factory()->create();
        $this->assertSame('default', Configuration::getString(ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST, $user, 'default'));
        $this->assertSame(546231, Configuration::getInt(ConfigurationKey::DASHBOARD_BTN_IMPORT_MEMBERS, $user, 546231));
        $this->assertTrue(Configuration::getBool(ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE, $user, true));
    }

    public function test_store_and_get_global(): void
    {
        $this->assertNull(Configuration::storeString(ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST, 'string_value_1'));
        $this->assertSame('string_value_1', Configuration::storeString(ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST, 'string_value_2'));
        $this->assertSame('string_value_2', Configuration::getString(ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST));

        $this->assertNull(Configuration::storeInt(ConfigurationKey::DASHBOARD_BTN_IMPORT_MEMBERS, 345234));
        $this->assertSame(345234, Configuration::storeInt(ConfigurationKey::DASHBOARD_BTN_IMPORT_MEMBERS, 465465));
        $this->assertSame(465465, Configuration::getInt(ConfigurationKey::DASHBOARD_BTN_IMPORT_MEMBERS));

        $this->assertNull(Configuration::storeBool(ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE, true));
        $this->assertTrue(Configuration::storeBool(ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE, false));
        $this->assertFalse(Configuration::getBool(ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE));
    }

    public function test_store_and_get_user(): void
    {
        $user = User::factory()->create();
        $this->assertNull(Configuration::storeString(ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST, 'string_value_1', $user));
        $this->assertSame('string_value_1', Configuration::storeString(ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST, 'string_value_2', $user));
        $this->assertSame('string_value_2', Configuration::getString(ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST, $user));

        $this->assertNull(Configuration::storeInt(ConfigurationKey::DASHBOARD_BTN_IMPORT_MEMBERS, 345234, $user));
        $this->assertSame(345234, Configuration::storeInt(ConfigurationKey::DASHBOARD_BTN_IMPORT_MEMBERS, 465465, $user));
        $this->assertSame(465465, Configuration::getInt(ConfigurationKey::DASHBOARD_BTN_IMPORT_MEMBERS, $user));

        $this->assertNull(Configuration::storeBool(ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE, true, $user));
        $this->assertTrue(Configuration::storeBool(ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE, false, $user));
        $this->assertFalse(Configuration::getBool(ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE, $user));
    }

    public function test_store_global_and_get_user(): void
    {
        $user = User::factory()->create();
        $this->assertNull(Configuration::storeString(ConfigurationKey::EVENT_FILTER_DEFAULT_START_TODAY, 'string_global_value_1'));
        $this->assertSame('string_global_value_1', Configuration::getString(ConfigurationKey::EVENT_FILTER_DEFAULT_START_TODAY, $user));

        $this->assertNull(Configuration::storeInt(ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE, 345234));
        $this->assertSame(345234, Configuration::getInt(ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE, $user));

        $this->assertNull(Configuration::storeBool(ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE, true));
        $this->assertTrue(Configuration::getBool(ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE, $user));
    }

    public function test_store_and_get_multiple_user(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $this->assertNull(Configuration::storeString(ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE, 'string_global_value_1'));
        $this->assertNull(Configuration::storeString(ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE, 'string_user_value_1', $user));
        $this->assertNull(Configuration::storeString(ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE, 'string_user2_value_1', $user2));
        $this->assertNull(Configuration::storeString(ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST, 'string_global3_value_1'));

        $this->assertSame('string_global_value_1', Configuration::storeString(ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE, 'string_global_value_2'));
        $this->assertSame('string_user_value_1', Configuration::storeString(ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE, 'string_user_value_2', $user));
        $this->assertSame('string_user2_value_1', Configuration::storeString(ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE, 'string_user2_value_2', $user2));

        $this->assertSame('string_global_value_2', Configuration::getString(ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE));
        $this->assertSame('string_user_value_2', Configuration::getString(ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE, $user));
        $this->assertSame('string_user2_value_2', Configuration::getString(ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE, $user2));

        $this->assertSame('string_global3_value_1', Configuration::getString(ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST, $user));
        $this->assertSame('string_global3_value_1', Configuration::getString(ConfigurationKey::DASHBOARD_BTN_BIRTHDAY_LIST, $user2));

    }
}
