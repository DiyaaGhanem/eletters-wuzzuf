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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('cover_letters')->nullable();
            $table->string('notice_period');
            $table->string('application_date');
            $table->float('expected_salary');
            $table->longText('answers');
            $table->text('cv');
            $table->string('candidate_profile_link');
            $table->bigInteger('job_id')->unsigned();
            $table->foreign("job_id")->references('id')->on('jobs');
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
