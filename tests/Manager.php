<?php

namespace dominx99\school;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Yaml\Yaml;
use Phinx\Config\Config as PhinxConfig;
use Phinx\Migration\Manager as PhinxManager;
use dominx99\school\Capsule as AppCapsule;
use dominx99\school\Config as AppConfig;

class Manager
{
    public function __construct()
    {
        AppConfig::set('environment', 'testing');
    }

    public function migrate()
    {
       $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'phinx.yml';
       $file = file_get_contents($path);
       $configArray = Yaml::parse($file);

       $config = new PhinxConfig($configArray);
       $manager = new PhinxManager($config, new StringInput(' '), new NullOutput());

       AppCapsule::init();
       $manager->migrate('testing');
    }
}
