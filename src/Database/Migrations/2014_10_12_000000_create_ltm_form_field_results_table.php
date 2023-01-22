<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFieldResultsTable extends Migration
{
    /**
     *
     */
    const table = 'ltm_form_field_results';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::table, function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('form_field_id');
            $table->string('target_table');
            $table->integer('target_id');
            $table->string('type');
            $table->string('value')->nullable();
            $table->integer('created_by')->default('0');
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
