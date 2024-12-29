<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Make all columns nullable with default null
            $table->string('title')->nullable()->default(null)->change();
            $table->text('description')->nullable()->default(null)->change();
            $table->unsignedBigInteger('assigned_to')->nullable()->default(null)->change();
            $table->unsignedBigInteger('created_by')->nullable()->default(null)->change();
            $table->string('status')->nullable()->default(null)->change();
            $table->dateTime('due_date')->nullable()->default(null)->change();
            $table->string('priority')->nullable()->default(null)->change();
            $table->unsignedBigInteger('team_id')->nullable()->default(null)->change();
            $table->string('name')->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Rollback all changes and make columns non-nullable (or revert to previous state)
            $table->string('title')->nullable(false)->default(null)->change();
            $table->text('description')->nullable(false)->default(null)->change();
            $table->unsignedBigInteger('assigned_to')->nullable(false)->default(null)->change();
            $table->unsignedBigInteger('created_by')->nullable(false)->default(null)->change();
            $table->string('status')->nullable(false)->default(null)->change();
            $table->dateTime('due_date')->nullable(false)->default(null)->change();
            $table->string('priority')->nullable(false)->default(null)->change();
            $table->unsignedBigInteger('team_id')->nullable(false)->default(null)->change();
            $table->string('name')->nullable(false)->default(null)->change();
        });
    }
}
