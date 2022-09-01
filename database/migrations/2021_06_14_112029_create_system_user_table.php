<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('system_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('main')->default(false); //defines whether they are dedicated to each other.
            $table->timestamps();

            $table->foreign('system_id')
                ->references('id')
                ->on('systems')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('system_user');
    }
}
