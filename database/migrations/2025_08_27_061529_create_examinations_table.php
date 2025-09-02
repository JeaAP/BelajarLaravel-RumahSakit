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
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->text('diagnosis');
            $table->text('treatment_plan');
            $table->text('medications')->nullable();
            $table->text('dosage')->nullable();
            $table->boolean('needs_hospitalization')->default(false);
            $table->date('admission_date')->nullable();
            $table->date('discharge_date')->nullable();
            $table->enum('patient_status', ['under_treatment', 'recovered', 'referred'])->default('under_treatment');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('visit_id')->references('id')->on('visits')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
