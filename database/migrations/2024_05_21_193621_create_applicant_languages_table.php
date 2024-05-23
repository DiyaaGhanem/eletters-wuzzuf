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
        Schema::create('applicant_languages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('applicant_id')->unsigned();
            $table->foreign("applicant_id")->references('id')->on('applicants');
            $table->bigInteger('language_id')->unsigned();
            $table->foreign("language_id")->references('id')->on('languages');
            $table->enum('level', ['Elementary proficiency', 'Limited working proficiency', 'Professional working proficiency', 'Full professional proficiency', 'Native or bilingual proficiency'])->default('Elementary proficiency');
            $table->enum('rating', ['1', '2', '3', '4', '5'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_languages');
    }
};
