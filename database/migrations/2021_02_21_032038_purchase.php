<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Purchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase', function (Blueprint $table) {

            $table->string('purchaseId',17)->primary();
            $table->foreign('purchaseId')
                ->references('uid')
                ->on('devices')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->dateTimeTz('expireDate')->unique();
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
        Schema::drop('purchase');
    }
}
