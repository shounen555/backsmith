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
        Schema::create('tutors', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('cin');
            $table->string('profession')->nullable();
            $table->string('tel_domicile')->nullable();
            $table->string('tel_bureau')->nullable();
            $table->string('gsm')->nullable();
            $table->text('observation')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutors');
    }
};
