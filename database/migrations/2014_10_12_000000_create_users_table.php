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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('age');
            $table->bigInteger('phone_number');
            $table->string('password');
            $table->text('address');
            $table->string('postal_code');
            $table->string('country');
            $table->string('province');
            $table->string('city');
            $table->enum('gender',['male','female']);
            $table->enum('status',['enable','disable'])->default('enable');
            $table->string('email')->unique();
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
