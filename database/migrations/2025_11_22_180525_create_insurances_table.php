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
        Schema::create('insurances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->string('name', 100);
            $table->string('type', 50); // bpjs / private / company / selfpay
            $table->text('contact_info')->nullable();
            $table->string('external_id', 64)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestampsTz(); // created_at & updated_at timestamptz
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
