<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Toyota Veloz Hybrid 3D');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('mime_type')->default('model/gltf-binary');
            $table->unsignedBigInteger('file_size')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('default_color')->default('blue');
            $table->decimal('default_opacity', 3, 2)->default(0.50);
            $table->json('meta_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_models');
    }
};
