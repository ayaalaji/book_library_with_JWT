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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author')->min(3)->max(100);
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('description')->min(5)->max(255);
            $table->date('published_at');
            $table->enum('availability_of_book',['available','not_available'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
