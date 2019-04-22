<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamicOffers', function (Blueprint $table) {
            $table->increments('id', true);
            $table->string('title');
            $table->string('description');
            $table->datetime('startDate');
            $table->datetime('expiryDate');
            $table->string('promoCode');
            $table->string('image');
            $table->integer('packageCode');
            $table->boolean('isBucket');
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
