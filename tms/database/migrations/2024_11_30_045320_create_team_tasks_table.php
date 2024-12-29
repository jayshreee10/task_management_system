<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamTasksTable extends Migration
{
    public function up()
    {
        Schema::create('team_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade'); // Foreign key referencing Team
            $table->string('name');  // Task name
            $table->text('description')->nullable(); // Task description
            $table->timestamps();
            $table->text('comments')->nullable();
            $table->json('attachments')->nullable(); // You can store the file paths in a JSON column or use a different method for storing file data
        });
    }

    public function down()
    {
        Schema::dropIfExists('team_tasks');
    }
}

