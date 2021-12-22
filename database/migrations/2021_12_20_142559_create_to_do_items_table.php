<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToDoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('to_do_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('end_date');
            $table->time('end_time')->nullable();
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->unsignedInteger('reminder')->nullable();
            $table->text('reminder_url')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('priority_id')->references('id')->on('priorities');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('to_do_items');
    }
}
