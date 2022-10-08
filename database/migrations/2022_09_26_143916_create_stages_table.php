<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->integer('tournament_id')->unsigned();
            $table->dateTime('register_start');
            $table->dateTime('register_end');
            $table->dateTime('race_start');
            $table->string('title');
            $table->enum('status', ['active', 'default', 'group', 'flot', 'finished'])->default('active');
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('stages');
    }
};
