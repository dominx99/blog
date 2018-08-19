<?php

namespace dominx99\school;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Yaml\Yaml;
use Phinx\Config\Config as PhinxConfig;
use Phinx\Migration\Manager as PhinxManager;
use Phinx\Console\PhinxApplication;
use Slim\Http\Response;
use dominx99\school\Models\User;

trait DatabaseTrait
{
    protected $user;

    public function setUserData()
    {
        $this->user = [
            'email' => 'aaa@aaa.com',
            'name' => 'aaa',
            'password' => 'abcdef'
        ];
    }

    /**
     * Function which has to migrate init Capsule as sqlite in memory
     * and migrate database
     */
    public function migrate()
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'phinx.php';
        $configArray = require($path);

        $config = new PhinxConfig($configArray);
        $manager = new PhinxManager($config, new StringInput(' '), new NullOutput());

        $manager->migrate('testing');
        $manager->seed('testing');
    }

    protected function rollback()
    {
        $app = new PhinxApplication();
        $app->doRun(new StringInput("rollback -e testing -f"), new NullOutput());
    }
}
