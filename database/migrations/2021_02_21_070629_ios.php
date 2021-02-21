<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ios', function (Blueprint $table) {

            $table->string('purchaseId',17)->primary();
            $table->foreign('purchaseId')
                ->references('purchaseId')
                ->on('purchases')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('receipt',10)->unique();
            $table->enum('validation', [0, 1]);
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
        Schema::drop('ios');
    }
}