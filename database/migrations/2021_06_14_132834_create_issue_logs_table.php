<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('issue_id');
            $table->string('action');
            $table->text('message');
            $table->timestamps();

            $table->foreign('issue_id')
                ->references('id')
                ->on('issues')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issue_logs');
    }
}
