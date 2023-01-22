<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTranscriptsTable extends Migration
{
    /**
     *
     */
    const table = 'ltm_task_transcripts';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::table, function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('task_assignment_id');
            $table->enum('type', ['Bcc', 'Cc']);
            $table->enum('is_active', ['0', '1']);
            $table->integer('created_by');
            $table->timestamp('trashed_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
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
