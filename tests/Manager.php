<?php

namespace dominx99\school;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Yaml\Yaml;
use Phinx\Config\Config as PhinxConfig;
use Phinx\Migration\Manager as PhinxManager;

trait Manager
{
    /**
     * Function which has to call function which will set up config of App
     */
    public function configTesting()
    {
        Config::set('environment', 'testing');
    }

    /**
     * Function which has to migrate init Capsule as sqlite in memory
     * and migrate database
     */
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

    /**
     * @return \Slim\App instance
     * Function which has only to call and create Slim App instance 
     */
    public function createApplication()
    {
        $this->configTesting();

        return (new App)->boot();
    }
}
