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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('university');
            $table->string('logo')->nullable()->default('default.png');
            $table->string('major')->nullable();
            $table->string('grade')->nullable();
            $table->string('degree')->nullable();
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
        Schema::dropIfExists('education');
    }
};
