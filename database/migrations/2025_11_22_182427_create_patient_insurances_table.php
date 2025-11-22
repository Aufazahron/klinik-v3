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
        Schema::create('patient_insurances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('insurance_id');
            $table->string('member_number', 50)->nullable();
            $table->string('class', 20)->nullable();
            $table->boolean('active')->default(true);
            $table->timestampsTz();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('insurance_id')->references('id')->on('insurances');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_insurances');
    }
};
