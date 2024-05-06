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
            $table->string('department');
            $table->string('job_type');
            $table->string('country');
            $table->string('job_location');
            $table->text('job_requirement');
            $table->string('job_level');
            $table->string('skills_keys');
            $table->longText('job_questions');
            $table->float('min_salary');
            $table->float('max_salary');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign("category_id")->references('id')->on('categories');
            $table->bigInteger('corporate_id')->unsigned()->nullable();
            $table->foreign("corporate_id")->references('id')->on('corporates')->nullOnDelete();
            // Many 2 MAny between users ('applicants') and job
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
