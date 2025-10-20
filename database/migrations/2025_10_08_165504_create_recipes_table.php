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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // اسم الوصفة
            $table->text('description')->nullable(); // شرح أو خطوات التحضير
            $table->string('image')->nullable(); // مسار الصورة
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // علاقة مع الكاتيغوري
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
