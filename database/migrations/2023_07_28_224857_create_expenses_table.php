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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 10, 2);
            $table->date('date');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('raison_id')->nullable();
            $table->string('raison_text')->nullable();
            $table->text('observation')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('type_id')->references('id')->on('expenses_types');
            $table->foreign('raison_id')->references('id')->on('raisons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
