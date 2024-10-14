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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->foreignId('student_id')
                  ->constrained(table: 'users')
                  ->cascadeOnDelete();
            $table->foreignId('course_id')
                  ->constrained(table: 'courses')
                  ->cascadeOnDelete();

            $table->string('status', 1);//pendiente, aprobada, rechazada        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
