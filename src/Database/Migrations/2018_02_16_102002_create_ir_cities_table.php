<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIrCitiesTable extends Migration
{

    const table = 'ltm_ir_cities';

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
            $table->integer('uid')->nullable()->default(null)->unsighned();
            $table->integer('province_id')->nullable()->default(null)->unsighned();
            $table->string('version', 255)->nullable()->default(null);
            $table->string('name', 255)->nullable()->default(null);
            $table->string('description', 255)->nullable()->default(null);
            $table->double('lng', 8, 2)->nullable()->default(null);
            $table->double('lat', 8, 2)->nullable()->default(null);
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
