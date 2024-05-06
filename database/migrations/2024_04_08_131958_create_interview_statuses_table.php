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
        Schema::create('interview_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('comments');
            $table->text('status');
            $table->text('interview_mail');
            $table->bigInteger('application_id')->unsigned();
            $table->foreign("application_id")->references('id')->on('applications');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_statuses');
    }
};
