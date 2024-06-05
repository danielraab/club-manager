<?php

namespace Tests\Feature\Configuration;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_missing_configs(): void
    {
        $this->assertNull(Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME));
        $this->assertNull(Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID));
        $this->assertNull(Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED));

        $user = User::factory()->create();
        $this->assertNull(Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME, $user));
        $this->assertNull(Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, $user));
        $this->assertNull(Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, $user));

        $this->assertEquals(
            'defaultText',
            Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME, $user, 'defaultText'));
        $this->assertEquals(
            12345,
            Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, $user, 12345));
        $this->assertTrue(
            Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, $user, true));
        $this->assertFalse(
            Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, $user, false));
    }

    public function test_store_global_and_get_global(): void
    {
        $this->refreshDatabase();

        Configuration::storeString(ConfigurationKey::APPEARANCE_APP_NAME, 'test string');
        Configuration::storeInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, 3465345);
        Configuration::storeBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, true);

        $this->assertEquals('test string', Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME));
        $this->assertEquals(3465345, Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID));
        $this->assertTrue(Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED));
    }

    public function test_store_user_and_get_user(): void
    {
        $this->refreshDatabase();
        $user = User::factory()->create();

        $this->assertNull(Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME));
        $this->assertNull(Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID));
        $this->assertNull(Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED));
        $this->assertNull(Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME, $user));
        $this->assertNull(Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, $user));
        $this->assertNull(Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, $user));

        Configuration::storeString(ConfigurationKey::APPEARANCE_APP_NAME, 'test string', $user);
        Configuration::storeInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, 3465345, $user);
        Configuration::storeBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, true, $user);

        $this->assertEquals('test string', Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME, $user));
        $this->assertEquals(3465345, Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, $user));
        $this->assertTrue(Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, $user));

        $this->assertNull(Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME));
        $this->assertNull(Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID));
        $this->assertNull(Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED));
    }

    public function test_store_global_and_get_user(): void
    {
        $this->refreshDatabase();

        Configuration::storeString(ConfigurationKey::APPEARANCE_APP_NAME, 'test string');
        Configuration::storeInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, 3465345);
        Configuration::storeBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, true);

        $user = User::factory()->create();
        $this->assertEquals('test string', Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME, $user));
        $this->assertEquals(3465345, Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, $user));
        $this->assertTrue(Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, $user));
    }

    public function test_store_user_and_get_global(): void
    {
        $this->refreshDatabase();
        $user = User::factory()->create();

        Configuration::storeString(ConfigurationKey::APPEARANCE_APP_NAME, 'user test string', $user);
        Configuration::storeInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, 1123123, $user);
        Configuration::storeBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, true, $user);

        $this->assertNull(Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME));
        $this->assertNull(Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID));
        $this->assertNull(Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED));

        $this->assertEquals(
            'test default',
            Configuration::getString(
                ConfigurationKey::APPEARANCE_APP_NAME,
                null,
                'test default'
            )
        );
        $this->assertEquals(1123123,
            Configuration::getInt(
                ConfigurationKey::APPEARANCE_APP_LOGO_ID,
                null,
                1123123
            )
        );
        $this->assertFalse(
            Configuration::getBool(
                ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED,
                null,
                false
            )
        );
    }

    public function test_store_user_and_get_user_multiple(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        Configuration::storeString(ConfigurationKey::APPEARANCE_APP_NAME, 'user1 test string', $user);
        Configuration::storeInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, 11231, $user);
        Configuration::storeBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, false, $user);

        Configuration::storeString(ConfigurationKey::APPEARANCE_APP_NAME, 'user2 test string', $user2);
        Configuration::storeInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, 11231231, $user2);
        Configuration::storeBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, true, $user2);

        $this->assertEquals('user1 test string', Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME, $user));
        $this->assertEquals(11231, Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, $user));
        $this->assertFalse(Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, $user));

        $this->assertEquals('user2 test string', Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME, $user2));
        $this->assertEquals(11231231, Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID, $user2));
        $this->assertTrue(Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, $user2));

        $this->assertNull(Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME));
        $this->assertNull(Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID));
        $this->assertNull(Configuration::getBool(ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED));
    }
}
