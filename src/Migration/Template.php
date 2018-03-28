<?php

use dominx99\school\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class $className extends Migration
{
    public function up()
    {
        $this->schema->create("$classNameLowerCase", function(Blueprint $table){
            $table->increments('id');

            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop("$classNameLowerCase");
    }
}
