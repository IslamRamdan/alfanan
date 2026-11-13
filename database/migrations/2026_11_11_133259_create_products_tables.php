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
        // 1. جدول المنتجات الرئيسي (مع دعم اللغتين)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');                    // اسم المنتج بالعربي
            $table->string('name_en');                    // اسم المنتج بالإنجليزي
            $table->text('description_ar')->nullable();   // الوصف بالعربي
            $table->text('description_en')->nullable();   // الوصف بالإنجليزي
            $table->decimal('price', 10, 2);
            $table->string('image');                      // الصورة الأساسية
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->onDelete('set null');
            $table->timestamps();
        });

        // 2. جدول الصور الفرعية (Gallery) للمنتج
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('image'); // مسار الصورة الفرعية
            $table->timestamps();
        });

        // 3. جدول مواصفات المنتج (مع دعم اللغتين لمفاتيح المواصفات والقيم)
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('key_ar')->nullable();   // اسم المواصفة بالعربي (مثلاً: اللون)
            $table->string('key_en')->nullable();   // اسم المواصفة بالإنجليزي (مثلاً: Color)
            $table->string('value_ar')->nullable(); // قيمة المواصفة بالعربي (مثلاً: أحمر)
            $table->string('value_en')->nullable(); // قيمة المواصفة بالإنجليزي (مثلاً: Red)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_specifications');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};
