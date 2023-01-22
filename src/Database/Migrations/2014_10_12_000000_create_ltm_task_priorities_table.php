<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskPrioritiesTable extends Migration
{
    /**
     *
     */
    const table = 'ltm_task_priorities';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::table, function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('task_id');
            $table->integer('user_id');
            $table->tinyInteger('importance');
            $table->tinyInteger('immediate');
            //$table->integer('timestamp');
            //$table->enum('is_active', ['0', '1']);
            $table->integer('created_by')->unsigned()->nullable()->default(0);
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
