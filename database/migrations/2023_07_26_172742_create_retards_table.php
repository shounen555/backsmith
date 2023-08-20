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
        Schema::create('retards', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->boolean('is_justified')->default(false);
            $table->text('justification')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retards');
    }
};
