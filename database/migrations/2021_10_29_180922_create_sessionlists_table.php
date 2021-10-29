<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessionlists', function (Blueprint $table) {
            $table->integer('content_id');
            $table->increments('session_id');
            $table->string('session_name');
            $table->string('rule');
            $table->integer('numpeople');
            $table->integer('nummatchpeople')->default(0);
            $table->integer('numaccess')->default(0);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessionlists');
    }
}
