<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTeamIdInTasksTable extends Migration
{
    public function up()
    {

        if (!Schema::hasColumn('tasks', 'team_id')) {
            Schema::table('tasks', function (Blueprint $table) {

                $table->unsignedBigInteger('team_id')->nullable()->after('assigned_to');
                $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            });
        }
    }

    public function down()
    {

        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable()->after('assigned_to');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });

    }
}

