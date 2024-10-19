<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->index()->name('activity_user_id');
            $table->string('log_name');
            $table->text('log_description');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at');
        });
        
        Schema::create('scrum_board_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scrum_board_id')->references('id')->on('scrumboards')->onDelete('cascade')->name('activity_scrumboard_id')->index();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->name('scrumboard_user_id');
            $table->string('log_name');
            $table->text('log_description');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scrum_board_activity_logs');

        Schema::dropIfExists('activity_logs');
    }
};
