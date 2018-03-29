<?php

namespace dominx99\school;

use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testThatEnvironmentIsNotEmptyWithSettingProperty()
    {
        Config::set('environment', 'testing');
        $env = Config::get('environment');

        $this->assertFalse(empty($env));
    }

    public function testThatEnvironmentIsNotEmptyWithoutSettingProperty()
    {
        Config::set('environment', null);
        $env = Config::get('environment');

        $this->assertFalse(empty($env));
        $this->assertEquals($env, 'development');
    }
}
