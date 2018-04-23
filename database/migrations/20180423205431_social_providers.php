<?php

use dominx99\school\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class SocialProviders extends Migration
{
    public function up()
    {
        $this->schema->create("social_providers", function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('provider_id', 255);
            $table->string('provider');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop("social_providers");
    }
}
