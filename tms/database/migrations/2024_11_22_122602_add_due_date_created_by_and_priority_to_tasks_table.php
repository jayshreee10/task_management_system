<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDueDateCreatedByAndPriorityToTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {

            $table->dateTime('due_date')->nullable()->after('status');


            $table->unsignedBigInteger('created_by')->nullable()->after('due_date');

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');


            $table->enum('priority', ['High', 'Medium', 'Low'])->default('Medium')->after('created_by');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {

            $table->dropForeign(['created_by']);


            $table->dropColumn(['due_date', 'created_by', 'priority']);
        });
    }
}
