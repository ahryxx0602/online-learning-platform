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
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('detail')->nullable();

            // Quan trọng – Cho phép null
            $table->unsignedBigInteger('teacher_id')->nullable();

            $table->string('thumbnail')->nullable();

            // Giá nên là integer để chính xác (float dễ lỗi)
            $table->integer('price')->default(0)->unsigned();
            $table->integer('sale_price')->nullable()->unsigned(); // CHO PHÉP NULL

            $table->string('code', 100)->nullable();
            $table->integer('durations')->default(0)->unsigned();
            $table->boolean('is_document')->default(0);
            $table->text('supports')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
