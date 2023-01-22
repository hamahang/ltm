<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectSettingsTable extends Migration
{
    /**
     *
     */
    const table = 'ltm_subject_settings';

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
            $table->integer('subject_id');
            $table->string('token');
            $table->string('url');
            $table->integer('report_id');
            $table->integer('template_id');
            $table->string('column_id', 255);
            $table->string('column_concat', 255)->nullable()->default(null);
            $table->enum('type', ['1', '2'])->default('1');
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
