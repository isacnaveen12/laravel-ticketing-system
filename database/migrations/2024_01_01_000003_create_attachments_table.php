<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->string('filename');
            $table->string('original_name');
            $table->string('file_path');
            $table->unsignedInteger('file_size');
            $table->string('mime_type');
            $table->timestamps();

            $table->index(['ticket_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};