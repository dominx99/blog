<?php

use dominx99\school\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class Users extends Migration
{
    public function up()
    {
        $this->schema->create("users", function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('name');
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop("users");
    }
}
