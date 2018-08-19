<?php

namespace dominx99\school;

use Dotenv\Dotenv;

class EnvLoader
{
    /**
     * @var string $root path to the main folder
     */
    static $root = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

    /**
     * @var string $envFile name of file .env | .env,testing
     */
    protected $envFile;

    /**
     * @param string $envFile
     */
    public function __construct(string $envFile)
    {
        $this->envFile = $envFile;
    }

    /**
     * Load variables from .env to global $_ENV variable
     *
     * @return void
     */
    public function load(): void
    {
        if (file_exists(self::$root . $this->envFile)) {
            $dotenv = new Dotenv(self::$root, $this->envFile);
            $dotenv->load();
        }
    }
}
