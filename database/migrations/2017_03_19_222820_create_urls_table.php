<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->unsignedInteger('uid');
            $table->text('url');
        });

        // Set auto increment value
        DB::update("ALTER TABLE `urls` AUTO_INCREMENT = " . env('DB_INCREMENTING_START', 1) . ";");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('urls');
    }
}
