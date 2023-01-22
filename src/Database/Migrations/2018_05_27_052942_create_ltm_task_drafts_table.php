<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ltm_task_drafts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->tinyInteger('type');
            $table->tinyInteger('report_on_create_point');
            $table->tinyInteger('report_on_completion_point');
            $table->tinyInteger('report_to_managers');
            $table->tinyInteger('importance');
            $table->integer('duration_timestamp');
            $table->string('title');
            $table->integer('timing_type');
            $table->string('desc');
            $table->tinyInteger('end_on_assigner_accept');
            $table->tinyInteger('transferable');
            $table->longText('users');
            $table->longText('transcripts');
            $table->longText('keywords');
            $table->longText('files');
            $table->integer('created_by');
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
        Schema::dropIfExists('task_drafts');
    }
}
