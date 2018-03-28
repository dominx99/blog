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

    protected static $environment;

    public static function setEnvironment($environment)
    {
        self::$environment = $environment;
    }

    public function init()
    {
        $this->capsule = Capsule::init(self::$environment ? self::$environment : 'development');
        $this->schema = $this->capsule->schema();
    }
}
