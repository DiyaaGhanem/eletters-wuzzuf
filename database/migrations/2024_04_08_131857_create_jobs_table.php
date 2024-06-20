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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('status', ['Pending', 'Published', 'Rejected', 'Not Published'])->default('Pending');
            $table->string('department');
            $table->string('job_type');
            $table->string('country');
            $table->string('job_location');
            $table->longText('job_requirement');
            $table->string('job_level');
            $table->longText('job_questions');
            $table->float('min_salary')->nullable();
            $table->float('max_salary')->nullable();
            $table->bigInteger('corporate_id')->unsigned()->nullable();
            $table->foreign("corporate_id")->references('id')->on('corporates')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
