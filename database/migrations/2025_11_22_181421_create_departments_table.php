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
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->string('name', 100);
            $table->string('code', 20)->nullable(); // Kode poli (IGD/UMUM/GIGI, dll)
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('organization_id', 64)->nullable();
            $table->string('location_id', 64)->nullable();
            $table->string('external_id', 64)->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
