<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration
{

    const table = 'ltm_cities';

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
            $table->integer('province_id')->nullable()->default(null)->unsighned();
            $table->string('name', 255)->nullable()->default(null);
            $table->string('center', 255)->nullable()->default(null);
            $table->string('version', 255)->nullable()->default(null);
            $table->double('lng', 8, 2)->nullable()->default(null);
            $table->double('lat', 8, 2)->nullable()->default(null);
            $table->integer('code')->unsigned()->nullable()->default(null);
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
