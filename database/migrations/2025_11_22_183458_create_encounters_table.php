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
        Schema::create('encounters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('practitioner_id')->nullable(); // dokter
            $table->unsignedBigInteger('department_id'); // poli
            $table->timestampTz('encounter_datetime')->nullable();
            $table->string('encounter_status', 50)->default('waiting'); // waiting/called/in_progress/finished/cancelled
            $table->string('encounter_code', 50)->nullable(); // nomor antrian per poli per hari
            $table->text('chief_complaint')->nullable(); // keluhan utama
            $table->string('external_id', 64)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestampsTz();

            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('practitioner_id')->references('id')->on('practitioners');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encounters');
    }
};
