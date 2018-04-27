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
    /**
     * Function which has to migrate init Capsule as sqlite in memory
     * and migrate database
     */
    public function migrate()
    {
        $app = new PhinxApplication();
        $app->doRun(new StringInput("migrate -e testing"), new NullOutput());

        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'phinx.yml';
        $file = file_get_contents($path);
        $configArray = Yaml::parse($file);

        $config = new PhinxConfig($configArray);
        $manager = new PhinxManager($config, new StringInput(' '), new NullOutput());

        $manager->migrate('testing');
    }

    protected function rollback()
    {
        $app = new PhinxApplication();
        $app->doRun(new StringInput("rollback -e testing -f"), new NullOutput());
    }

    public function register()
    {
        $this->params = [
            'email' => 'ddd@ddd.com',
            'name' => 'ddd',
            'password' => 'dddddd'
        ];

        $request = $this->newRequest([
            'uri' => '/register',
            'method' => 'post',
        ], $this->params);

        return $response = ($this->app)($request, new Response());
    }
}
