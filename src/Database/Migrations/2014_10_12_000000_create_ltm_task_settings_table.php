<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     *
     */
    const table = 'ltm_task_settings';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(null);
            $table->enum('is_acive_email', ['0', '1'])->default(0);
            $table->enum('is_acive_sms', ['0', '1'])->default(0);
            $table->enum('is_acive_messenger', ['0', '1'])->default(0);
            $table->enum('responsible_sms', ['0', '1'])->default(0);
            $table->enum('responsible_email', ['0', '1'])->default(0);
            $table->enum('responsible_messenger', ['0', '1'])->default(0);
            $table->enum('transcript_email', ['0', '1'])->default(0);
            $table->enum('transcript_sms', ['0', '1'])->default(0);
            $table->enum('transcript_messenger', ['0', '1'])->default(0);
            $table->enum('recive_email_is_active', ['0', '1'])->default(0);
            $table->enum('recive_sms_is_active', ['0', '1'])->default(0);
            $table->enum('recive_messenger_is_active', ['0', '1'])->default(0);
            $table->integer('created_by');
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
