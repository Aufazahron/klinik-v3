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
        Schema::create('practitioners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('full_name');
            $table->string('identifier')->nullable();
            $table->string('role')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('external_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('password')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practitioners');
    }
};
