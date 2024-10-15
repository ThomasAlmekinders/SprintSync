<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');

            $table->string('username')->unique()->nullable()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number')->unique()->nullable();

            $table->text('profile_bio')->nullable();
            $table->string('profile_picture')->nullable()->default('/default_profile.svg');

            $table->boolean('is_administrator')->default(false);

        });


        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->index();
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();
            $table->string('city')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');

            $table->dropColumn('username');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('phone_number');

            $table->dropColumn('profile_bio');
            $table->dropColumn('profile_picture');

            $table->dropColumn('is_administrator');

        });


        Schema::dropIfExists('addresses');
    }
};
