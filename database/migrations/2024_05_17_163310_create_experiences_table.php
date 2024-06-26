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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('logo')->nullable()->default('default.png');
            $table->string('job_title');
            $table->text('description');
            $table->enum('job_type', ['Full Time', 'Part Time', 'Freelance'])->default('Full Time');
            $table->enum('job_location', ['On Site', 'Remote', 'Hybrid'])->default('On Site');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->bigInteger('applicant_id')->unsigned();
            $table->foreign("applicant_id")->references('id')->on('applicants');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
