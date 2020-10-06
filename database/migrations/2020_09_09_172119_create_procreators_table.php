<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcreatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procreators', function (Blueprint $table) {
            $table->id();
            $table->char('fio', 100);
            $table->char('phone', 20)->unique();
            $table->char('vk_id', 150)->nullable();
            $table->char('viber_id', 150)->nullable();

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
        Schema::dropIfExists('procreators');
    }
}