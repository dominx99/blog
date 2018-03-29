<?php

namespace dominx99\school\Migration;

use dominx99\school\Capsule;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration
{
    /** @var \Illuminate\Database\Capsule\Manager $capsule */
    public $capsule;
    /** @var \Illuminate\Database\Schema\Builder $capsule */
    public $schema;

    protected static $env;

    public static function setEnvironment($env)
    {
        self::$env = $env;
    }

    public function init()
    {
        $this->capsule = Capsule::init(self::$env ? self::$env : 'development');
        var_dump('environment:' . self::$env);
        $this->schema = $this->capsule->schema();
    }
}
