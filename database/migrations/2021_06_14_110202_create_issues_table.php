<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('system_id');
            $table->unsignedBigInteger('user_id')->nullable(); //assigned developer
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('type'); //bug|feature
            $table->tinyInteger('urgency')->default(1); //1 - 5
            $table->tinyInteger('importance')->default(1); //1 - 5
            $table->string('page_title')->nullable();
            $table->text('page_url')->nullable();
            $table->string('requester_name')->nullable();
            $table->string('requester_email')->nullable();
            $table->string('requester_dept')->nullable();
            $table->integer('days')->nullable();
            $table->dateTime('assigned_at')->nullable();
            $table->dateTime('planned_start_at')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->tinyInteger('status')->default(0); //0-unassigned, 1-assigned 3-started, 4-paused, 5-completed, 6-rejected
            $table->timestamps();

            $table->foreign('system_id')
                ->references('id')
                ->on('systems')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}
