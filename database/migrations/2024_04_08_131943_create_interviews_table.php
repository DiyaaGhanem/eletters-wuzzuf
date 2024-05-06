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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->string('comments');
            $table->text('status');
            $table->datetime('date');
            $table->text('interview_mail')->nullable();
            $table->text('location');
            $table->bigInteger('review_id')->unsigned();
            $table->foreign("review_id")->references('id')->on('reviews');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
