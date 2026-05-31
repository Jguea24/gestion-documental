<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained('folders')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('file_name');
            $table->string('original_name');
            $table->string('extension', 32);
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size');
            $table->string('path');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['folder_id', 'original_name']);
            $table->index(['extension']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
