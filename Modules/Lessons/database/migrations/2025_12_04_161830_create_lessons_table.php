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
            $table->increments('id');
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->integer('video_id')->unsigned()->nullable();
            $table->integer('document_id')->unsigned()->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('course_id')->nullable();
            $table->boolean('is_trial')->default(0);
            $table->integer('views')->default(false);
            $table->integer('position')->default(0);
            $table->float('duration')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            // Liên kết khóa ngoại
            $table->foreign('video_id')
            ->references('id')->on('videos')
            ->nullOnDelete();
            $table->foreign('document_id')
            ->references('id')->on('documents')
            ->nullOnDelete();
            $table->foreign('parent_id')
            ->references('id')->on('lessons')
            ->nullOnDelete();
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
