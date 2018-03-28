<?php

use dominx99\school\Migration\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->schema->create('users', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('name');
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('users');
    }
}
