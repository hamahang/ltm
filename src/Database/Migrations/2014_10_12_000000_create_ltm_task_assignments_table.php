<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskAssignmentsTable extends Migration
{
    /**
     *
     */
    const table = 'ltm_task_assignments';

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
            $table->integer('task_id');
            $table->integer('previous_id')->default('0');
            $table->integer('assigner_id')->comment('کاربری که این تسک رو به employee اختصاص داده');
            $table->integer('employee_id')->comment('کابری که تسک به اون اختصاص داده شده');
            $table->integer('transmitter_id')->comment('انتقال دهندهء تسک');
            $table->integer('transferred_to_id')->comment('کاربری که تسک از employee به اون منتقل شده');
            $table->integer('integrated_task_id')->comment('شناسه جدید تسک، وقتی چند تسک به یک تسک تبدیل می شوند');
            $table->timestamp('rejected_at')->nullable();
            $table->integer('action_do_form_id')->nullable();
            $table->string('action_do_fields_code')->nullable();
            $table->integer('action_transfer_form_id')->nullable();
            $table->string('action_transfer_fields_code')->nullable();
            $table->integer('action_reject_form_id')->nullable();
            $table->string('action_reject_fields_code')->nullable();
            $table->enum('end_on_assigner_accept', ['0', '1']);
            $table->enum('transferable', ['0', '1']);
            $table->enum('rejectable', ['0', '1']);
            $table->enum('is_active', ['0', '1'])->default('1');
            $table->integer('created_by');
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
