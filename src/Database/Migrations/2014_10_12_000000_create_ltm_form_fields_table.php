<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFieldsTable extends Migration
{
    /**
     *
     */
    const table = 'ltm_form_fields';

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
            $table->integer('form_id');
            $table->enum('type', ['checkbox', 'file', 'label', 'lfm', 'radio', 'select', 'text', 'textarea']);
            $table->string('field_class');
            $table->string('field_id');
            $table->string('field_name');
            $table->string('field_title')->nullable();
            $table->string('field_placeholder');
            $table->text('field_value')->nullable();
            $table->text('field_style')->nullable();
            $table->text('field_attributes')->nullable();
            $table->text('field_options')->nullable();
            $table->text('validation_js')->nullable();
            $table->text('validation_php')->nullable();
            $table->text('setting')->nullable();
            $table->string('label_class')->nullable();
            $table->string('label_title')->nullable();
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
