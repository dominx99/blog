<?php

namespace dominx99\school\Migration;

use Phinx\Migration\AbstractMigration;
use dominx99\school\Capsule;
use dominx99\school\Config;

class Migration extends AbstractMigration
{
    /** @var \Illuminate\Database\Capsule\Manager $capsule */
    public $capsule;
    /** @var \Illuminate\Database\Schema\Builder $capsule */
    public $schema;

    public function init()
    {
        $this->capsule = Capsule::init();
        $this->schema = $this->capsule->schema();
    }
}
