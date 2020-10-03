<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("hour_id");
            $table->unsignedBigInteger("day_id");
            $table->unsignedBigInteger("group_id");
            $table->unsignedTinyInteger('place_count')->default(8);
            $table->unsignedBigInteger('week_id');
            $table->boolean('active')->default(0);
            $table->timestamps();

            $table->foreign('hour_id')->references('id')->on('hours')->onDelete('cascade');
            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
            $table->foreign('week_id')->references('id')->on('weeks')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');

            $table->unique([
                'hour_id', 'day_id', 'group_id', 'week_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
