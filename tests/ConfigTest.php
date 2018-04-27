<?php

namespace dominx99\school;

use PHPUnit\Framework\TestCase;

class ConfigTest extends BaseTestCase
{
    public function testThatEnvironmentIsNotEmptyWithSettingProperty()
    {
        Config::set('environment', 'testing');
        $env = Config::get('environment');

        $this->assertFalse(empty($env));
    }

    public function testThatIndexIsNotEmptyEvenWithoutSettingProperty()
    {
        Config::set('environment', null);
        $env = Config::get('environment');
        $key = Config::get('jwtKey');

        $this->assertFalse(empty($key));
        $this->assertFalse(empty($env));
        $this->assertEquals($env, 'development');
    }
}
