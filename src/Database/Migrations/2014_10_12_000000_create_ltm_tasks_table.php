<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     *
     */
    const table = 'ltm_tasks';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('started_by');
            $table->string('code');
            $table->string('title');
            $table->integer('subject_id');
            $table->text('description')->nullable()->default(null);
            $table->tinyInteger('type');
            $table->integer('file_no')->nullable()->default(null);
            $table->dateTime('start_time');
            $table->integer('duration_timestamp');
            $table->integer('schedule_id');
            $table->integer('template_id');
            $table->enum('is_active', ['0', '1']);
            $table->integer('created_by');
            $table->string('vin')->nullable()->default(null);
            $table->integer('vin_form_id')->nullable()->default(null);
            $table->timestamp('terminated_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['code',], self::table . '_unique_code', 'BTREE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::table);
    }

}
