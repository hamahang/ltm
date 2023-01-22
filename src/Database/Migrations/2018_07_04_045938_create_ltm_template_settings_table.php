<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ltm_template_settings', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->enum('type', ['1','2'])->default('1');
            $table->string('text_footer');
            $table->integer('theme_nav');
            $table->integer('theme_sidebar');
            $table->longText('options');
            $table->integer('img_id');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_settings');
    }
}
