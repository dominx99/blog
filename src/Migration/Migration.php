<?php

namespace dominx99\school\Migration;

use dominx99\school\Capsule;
use dominx99\school\Config;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration
{
    /** @var \Illuminate\Database\Capsule\Manager $capsule */
    public $capsule;
    /** @var \Illuminate\Database\Schema\Builder $capsule */
    public $schema;

    public function init()
    {
        $this->capsule = Capsule::init(Config::get('environment'));
        $this->schema = $this->capsule->schema();
    }
}
