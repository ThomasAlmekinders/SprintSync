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

        Schema::create('scrumboard_sprints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scrumboard_id')->references('id')->on('scrumboards')->onDelete('cascade')->name('scrumboard_sprint_scrumboard_id')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('planned_start_date');
            $table->date('planned_end_date');
            $table->integer('sprint_order')->default(0);
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });

        Schema::create('scrumboard_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sprint_id')->references('id')->on('scrumboard_sprints')->onDelete('cascade')->name('scrumboard_task_sprint_id')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['to_do', 'in_progress', 'done'])->default('to_do');
            $table->timestamp('finished_at')->nullable();
            $table->integer('task_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scrumboard_tasks');

        Schema::dropIfExists('scrumboard_sprints');

        Schema::dropIfExists('scrumboard_user');

        Schema::dropIfExists('scrumboards');
    }
};