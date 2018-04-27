<?php

namespace dominx99\school\Migration;

use Phinx\Migration\AbstractMigration;
use dominx99\school\Capsule;

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
        $this->capsule = Capsule::getCapsule() ? Capsule::getCapsule() : Capsule::init();
        $this->schema = $this->capsule->schema();
    }
}
