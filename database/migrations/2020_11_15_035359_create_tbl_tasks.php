<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tasks', function (Blueprint $table) {
            $table->id()->length(32);
            $table->string('title', 255);
            $table->text('description');
            $table->integer('task_type_id')->length(32)->unsigned();
            $table->tinyInteger('is_active')->length(1)->unsigned();
            $table->integer('created_by')->length(32)->unsigned();
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
        Schema::dropIfExists('tbl_tasks');
    }
}
