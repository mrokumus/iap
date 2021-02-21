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

            $table->string('purchaseId', 17)->primary();
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
        Schema::drop('android');
    }
}
