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
            $table->id();
            $table->unsignedBigInteger('school_year_id')->nullable();
            $table->date('payment_date');
            $table->decimal('montant', 10, 2);
            $table->boolean('is_cheque')->default(false);
            $table->boolean('cheque_is_payed')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('cheque_societe')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('class_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('set null');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
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
