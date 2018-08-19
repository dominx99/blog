<?php

namespace dominx99\school\Migration;

use Illuminate\Database\Capsule\Manager;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration
{
    /**
     * @var \Illuminate\Database\Capsule\Manager $capsule
     */
    public $capsule;
    /**
     * @var \Illuminate\Database\Schema\Builder $schema
     */
    public $schema;

    /**
     * Stores Capsule and Schema instances
     */
    public function init()
    {
        $this->capsule = new Manager();
        $this->schema  = $this->capsule->schema();
    }
}
