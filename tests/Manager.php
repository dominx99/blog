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
       // $pdo = $capsule->connection()->getPdo();

       $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'phinx.yml';
       $file = file_get_contents($path);
       $configArray = Yaml::parse($file);

       // $configArray['environments']['testing'] = [
       //    'adapter'    => 'sqlite',
       //    'memory' => 'true',
       //    'connection' => $pdo
       // ];
       $config = new Config($configArray);
       $manager = new PhinxManager($config, new StringInput(' '), new NullOutput());

       Capsule::init('testing');
       $manager->migrate('testing');
    }
}
