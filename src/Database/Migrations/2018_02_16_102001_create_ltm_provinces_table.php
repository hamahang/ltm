<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProvincesTable extends Migration
{

    const table = 'ltm_provinces';

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
            $table->integer('center_city_id')->nullable()->default(null)->unsighned();
            $table->string('name', 255)->nullable()->default(null);
            $table->string('center_city_name', 255)->nullable()->default(null);
            $table->integer('code')->unsigned()->nullable()->default(null);
            $table->integer('code_clear')->unsigned()->nullable()->default(null);
            $table->string('version', 255)->nullable()->default('1');
            $table->enum('is_active', ['0','1'])->default('1');
            $table->integer('created_by')->nullable()->default(null)->unsigned();
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
