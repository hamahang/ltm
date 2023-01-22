<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjects extends Migration
{
    /**
     *
     */
    const table = 'ltm_subjects';

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
            $table->integer('parent_id');
            $table->string('code', 3);
            $table->string('title');
            $table->string('background_color', 255)->nullable()->default(null);
            $table->string('text_color', 255)->nullable()->default(null);
            $table->integer('order');
            $table->enum('is_active', ['0', '1'])->default('1');
            $table->integer('created_by')->unsigned()->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['code', ], self::table . '_unique_code', 'BTREE');
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
