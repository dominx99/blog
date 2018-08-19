<?php

use Phinx\Seed\AbstractSeed;

class BaseSeeder extends AbstractSeed
{
    const FACTORIES__PATH = __DIR__ . '\..\factories\\';

    /**
     * @var \Illuminate\Database\Eloquent\Factory
     */
    protected $factory;

    /** @var  \Faker\Generator */
    protected $faker;

    protected function init()
    {
        $this->faker   = Faker\Factory::create();
        $this->factory = new \Illuminate\Database\Eloquent\Factory($this->faker);
        $factories     = glob(static::FACTORIES__PATH . '*.php');
        foreach ($factories as $factory) {
            /** @noinspection PhpIncludeInspection */
            require $factory;
        }
    }
}
