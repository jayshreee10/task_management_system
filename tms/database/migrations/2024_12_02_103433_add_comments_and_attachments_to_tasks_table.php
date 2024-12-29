<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentsAndAttachmentsToTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {

            $table->text('comments')->nullable()->after('description');


            $table->json('attachments')->nullable()->after('comments');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {

            $table->dropColumn('comments');
            $table->dropColumn('attachments');
        });
    }
}
