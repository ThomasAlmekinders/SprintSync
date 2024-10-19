<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scrumboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->references('id')->on('users')->onDelete('cascade')->name('scrumboard_creator_id')->index();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);

            $table->timestamps();
        });

        Schema::create('scrumboard_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->name('user_scrumboard_user')->index();
            $table->foreignId('scrumboard_id')->references('id')->on('scrumboards')->onDelete('cascade')->name('scrumboard_scrumboard_user')->index();
            $table->timestamps();
            $table->unique(['user_id', 'scrumboard_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scrumboard_user');

        Schema::dropIfExists('scrumboards');
    }
};