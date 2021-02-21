<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Android extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('android', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('appId',5)->unique();
            $table->string('clientId',17);
            $table->dateTimeTz('expireDate');
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
        Schema::drop('android');

    }
}
