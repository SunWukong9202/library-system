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
        Schema::create('courses', function (Blueprint $table) {
            //key, name, credits, schedule, 
            $table->id();
            $table->string('key', 6)->unique();
            $table->string('name', 32);
            $table->tinyInteger('credits');
            $table->string('start');
            $table->string('end');
            $table->foreignId('teacher_id')
                  ->nullable()
                  ->constrained(table: 'users')
                  ->cascadeOnDelete();
            $table->timestamps();//horario, creditos,
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
