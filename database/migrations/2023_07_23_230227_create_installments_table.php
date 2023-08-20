<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->string('month',7);
            $table->date('payment_date');
            $table->decimal('montant', 10, 2);
            $table->boolean('is_cheque')->default(false);
            $table->boolean('cheque_is_payed')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('cheque_societe')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('class_id');
            $table->timestamps();

            // Add foreign key constraint to the students table
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
