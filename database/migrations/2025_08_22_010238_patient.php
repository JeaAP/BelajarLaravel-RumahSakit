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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('medical_record_number')->unique();
            $table->string('patient_name');
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->string('patient_address');
            $table->string('patient_city');
            $table->integer('patient_age')->virtualAs('YEAR(CURDATE()) - YEAR(birth_date)');
            $table->string('patient_disease');
            $table->unsignedBigInteger('doctor_id');
            $table->date('admission_date');
            $table->date('discharge_date')->nullable()->after('admission_date');
            $table->string('room_number');
            $table->enum('patient_status', ['dirawat', 'pulang'])->default('dirawat');
            
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('room_number')->references('room_id')->on('rooms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
