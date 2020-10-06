<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id')->default(1);
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('procreator_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedTinyInteger('age');
            $table->unsignedInteger('payed')->default(0);
            $table->unsignedInteger('pass')->default(0);
            $table->unsignedInteger('visit')->default(0);
            $table->char('fio', 170);

            $table->unique(['fio', 'age', 'procreator_id']);

            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->foreign('procreator_id')->references('id')->on('procreators')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');

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
        Schema::dropIfExists('clients');
    }
}
