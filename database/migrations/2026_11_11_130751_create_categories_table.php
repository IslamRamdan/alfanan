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
        // 1. جدول الأقسام الرئيسية (مع دعم العربي والإنجليزي)
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar'); // الاسم بالعربي
            $table->string('name_en'); // الاسم بالإنجليزي
            $table->timestamps();
        });

        // 2. جدول الأقسام الفرعية (مع دعم العربي والإنجليزي)
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar'); // الاسم بالعربي
            $table->string('name_en'); // الاسم بالإنجليزي
            // ربط القسم الفرعي بالقسم الرئيسي مع الحذف التلقائي
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
        Schema::dropIfExists('categories');
    }
};
