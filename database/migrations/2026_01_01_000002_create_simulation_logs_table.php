<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('simulation_logs', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable()->index();
            $table->string('action_type')->comment('power_on, power_off, gear_change, mode_change, customize');
            $table->string('mode')->nullable();
            $table->string('gear', 5)->nullable();
            $table->integer('speed')->default(0);
            $table->boolean('engine_active')->default(false);
            $table->boolean('mg2_active')->default(false);
            $table->boolean('battery_active')->default(false);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simulation_logs');
    }
};
