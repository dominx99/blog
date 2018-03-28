<?php

namespace dominx99\school;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Yaml\Yaml;
use Phinx\Config\Config;
use Phinx\Migration\Manager as PhinxManager;
use dominx99\school\Capsule;

class Manager
{
    public function migrate()
    {
       $capsule = Capsule::init('testing');
       $pdo = $capsule->connection('default')->getPdo();

       $configArray = Yaml::parse(file_get_contents(__DIR__ . '\..\phinx.yml'));
       $configArray['environments']['testing'] = [
          'adapter'    => 'sqlite',
          'connection' => $pdo
       ];
       $config = new Config($configArray);

       $manager = new PhinxManager($config, new StringInput(' '), new NullOutput());
       $manager->migrate('testing');
    }
}
