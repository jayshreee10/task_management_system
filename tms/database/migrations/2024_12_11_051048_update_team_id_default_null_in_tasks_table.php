<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTeamIdDefaultNullInTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Modify 'team_id' column to ensure it has a default value of NULL
            $table->unsignedBigInteger('team_id')->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        // Optionally, you can revert the change if you need to rollback
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable(false)->change();  // Remove default null, or change to previous state
        });
    }
}
