<?php

namespace dominx99\school;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Yaml\Yaml;
use Phinx\Config\Config as PhinxConfig;
use Phinx\Migration\Manager as PhinxManager;

trait Manager
{
    public function configTesting()
    {
        Config::set('environment', 'testing');
    }

    public function migrate()
    {
        $this->configTesting();

        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'phinx.yml';
        $file = file_get_contents($path);
        $configArray = Yaml::parse($file);

        $config = new PhinxConfig($configArray);
        $manager = new PhinxManager($config, new StringInput(' '), new NullOutput());

        Capsule::init();
        $manager->migrate('testing');
    }

    public function createApplication()
    {
        $this->configTesting();
        
        return (new App)->boot();
    }
}
