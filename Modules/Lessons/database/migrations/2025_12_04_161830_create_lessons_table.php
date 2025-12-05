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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->unsignedBigInteger('video_id')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->tinyInteger('is_trial')->default(0);
            $table->integer('views')->default(0);
            $table->integer('position')->default(0);
            $table->float('duration')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('course_id');
            $table->index('parent_id');
            $table->index('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
