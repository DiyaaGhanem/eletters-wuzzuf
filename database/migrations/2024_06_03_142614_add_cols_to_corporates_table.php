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
        Schema::table('corporates', function (Blueprint $table) {
            $table->string('tax_register_document')->after('status');
            $table->string('commercial_record_document')->after('status');
            $table->string('id_face')->after('status');
            $table->string('id_back')->after('status');
            $table->string('owner_title')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('corporates', function (Blueprint $table) {
            $table->dropColumn('tax_register_document');
            $table->dropColumn('commercial_record_document');
            $table->dropColumn('id_face');
            $table->dropColumn('id_back');
            $table->dropColumn('owner_title');
        });
    }
};
