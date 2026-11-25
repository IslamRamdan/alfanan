<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('fas fa-box-open');
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 10)->default('ر.س');
            $table->string('badge')->nullable();
            $table->string('badge_en')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('features');
            $table->json('features_en')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
