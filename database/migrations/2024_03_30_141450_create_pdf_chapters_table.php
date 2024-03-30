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
        Schema::create('pdf_chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pdf_upload_id')->constrained()->onDelete('cascade');
            $table->integer('chapter_number');
            $table->string('chapter_title');
            $table->string('chapter_path');
            $table->longText('chapter_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdf_chapters');
    }
};
