<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            $table->string('firstName');
            $table->string('lastName');
            $table->date('dateOfBirth');
            $table->string('personalPhoto')->nullable();
            $table->enum('gender', ['male', 'female']);

            // 🔥 العلاقات الصح
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('division');
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();

            $table->string('mobile');
            $table->string('password');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};