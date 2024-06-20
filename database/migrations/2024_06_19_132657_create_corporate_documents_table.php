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
        Schema::create('corporate_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('corporate_id')->unsigned();
            $table->foreign('corporate_id')->references('id')->on('corporates')->onDelete('cascade');

            $table->bigInteger('document_id')->unsigned();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

            $table->text('value');
            $table->enum('status', ['Under Review', 'Approved', 'Rejected'])->default('Under Review');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporate_documents');
    }
};
