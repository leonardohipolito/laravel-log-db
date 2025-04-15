<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        config()->set('database.connections.sqlite.database', date('Y-m-d').'-logs.sqlite');
        config()->set('logging.channels.db.connection', 'sqlite');
        $connection = config('logging.channels.db.connection') ?? config('database.default');
        Schema::connection($connection)->create('laravel_logs', function (Blueprint $table) {
            $table->id();
            $table->string('level_name');
            $table->unsignedSmallInteger('level');
            $table->string('message');
            $table->dateTime('logged_at');
            $table->json('context');
            $table->json('extra');
        });
    }
    
};
