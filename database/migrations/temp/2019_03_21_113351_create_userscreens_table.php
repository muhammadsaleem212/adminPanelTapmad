<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserscreensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('userScreens', function (Blueprint $table) {
            $table->increments('userScreenID', true);
            $table->string('userScreenName', 60);
            $table->string('screenDisplayName', 60);
            $table->integer('screenParentID');
            $table->string('screenParentName');
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
        //
    }
}
