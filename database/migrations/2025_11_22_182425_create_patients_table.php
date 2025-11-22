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
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->string('medical_record_number', 50)->unique();
            $table->string('full_name', 100);
            $table->string('gender', 10); // 'male','female','other','unknown'
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date');
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('national_id', 20)->nullable();
            $table->string('family_card_number', 20)->nullable();
            $table->char('marital_status', 1)->nullable(); // M/S/D/W
            $table->timestamp('registered_at')->nullable();
            $table->string('external_id', 64)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestampsTz();
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
