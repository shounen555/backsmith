<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name_fr');
            $table->string('last_name_fr');
            $table->string('first_name_ar');
            $table->string('last_name_ar');
            $table->string('matricule')->nullable();
            $table->string('cin')->nullable();
            $table->string('cen')->nullable();
            $table->string('gender')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('nationality')->nullable();
            $table->string('address')->nullable();
            $table->string('tel')->nullable();
            $table->float('monthly_payment')->nullable();
            $table->float('annually_payment')->nullable();
            $table->string('operator')->nullable();
            $table->string('health_state')->nullable();
            $table->string('medicine')->nullable();
            $table->string('medicine_tel')->nullable();
            $table->string('medicine_gsm')->nullable();
            $table->string('medicine_measures')->nullable();
            $table->string('previous_establishment')->nullable();
            $table->string('previous_level')->nullable();
            $table->float('last_year_overall_average')->nullable();
            $table->boolean('isStudent')->nullable();
            $table->string('pic')->nullable();
            $table->unsignedBigInteger('school_year_id')->nullable();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('set null');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('set null');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};