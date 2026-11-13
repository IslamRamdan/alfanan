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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            // محتوى المدونة (متعدد اللغات)
            $table->string('title_ar');
            $table->string('title_en');
            $table->text('description_ar'); // المحتوى أو الوصف التفصيلي
            $table->text('description_en');

            // الصورة الرئيسية للمدونة
            $table->string('image');

            // حقول الـ SEO (محركات البحث) متعددة اللغات
            $table->string('meta_title_ar')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_description_ar')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->string('meta_keywords_ar')->nullable(); // الكلمات المفتاحية مفصولة بفاصلة
            $table->string('meta_keywords_en')->nullable();
            $table->string('slug')->unique(); // للرابط اللطيف URL Slug

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
